@extends('admin.layout')

@section('title', 'Users - Leonce Admin')

@section('admin-content')
<h1 class="text-2xl font-bold text-gray-900 mb-6">Users</h1>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Name</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Email</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Posts</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                <tr class="border-b border-gray-50 {{ $index % 2 === 0 ? 'bg-white' : 'bg-slate-50/50' }} hover:bg-brand-50/30 transition">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold text-xs shrink-0">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-gray-900">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $user->email }}</td>
                    <td class="px-5 py-3">
                        <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-full">{{ $user->posts_count }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-gray-400">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
