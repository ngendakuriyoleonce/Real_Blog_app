<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );

        $categories = Category::factory()->count(5)->create();

        $colors = [
            [52, 152, 219],
            [231, 76, 60],
            [46, 204, 113],
            [155, 89, 182],
            [241, 196, 15],
            [230, 126, 34],
            [26, 188, 156],
            [192, 57, 43],
            [44, 62, 80],
            [127, 140, 141],
        ];

        $dir = public_path('postimage');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        Post::factory()
            ->count(20)
            ->published()
            ->create([
                'user_id' => $user->id,
            ])
            ->each(function ($post) use ($categories, $colors, $dir) {
                $post->update([
                    'category_id' => $categories->random()->id,
                ]);

                $color = $colors[$post->id % count($colors)];
                $filename = 'sample_' . $post->id . '_' . Str::slug($post->title) . '.png';
                $this->createPlaceholderImage($dir . '/' . $filename, 800, 450, $color, $post->title);
                $post->update(['image' => $filename]);
            });
    }

    private function createPlaceholderImage(string $path, int $width, int $height, array $color, string $text): void
    {
        $img = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($img, $color[0], $color[1], $color[2]);
        imagefill($img, 0, 0, $bg);

        $darker = imagecolorallocate($img, max(0, $color[0] - 30), max(0, $color[1] - 30), max(0, $color[2] - 30));
        for ($i = 0; $i < 20; $i++) {
            $x = random_int(0, $width);
            $y = random_int(0, $height);
            $r = random_int(20, 100);
            imagefilledellipse($img, $x, $y, $r, $r, $darker);
        }

        $white = imagecolorallocate($img, 255, 255, 255);
        $fontSize = 5;
        $wrapped = wordwrap($text, 30, "\n");
        $lines = explode("\n", $wrapped);
        $startY = ($height / 2) - (count($lines) * 14);

        foreach ($lines as $i => $line) {
            $lineWidth = imagefontwidth($fontSize) * strlen($line);
            $x = ($width - $lineWidth) / 2;
            imagestring($img, $fontSize, $x, $startY + ($i * 18), $line, $white);
        }

        imagepng($img, $path);
        imagedestroy($img);
    }
}
