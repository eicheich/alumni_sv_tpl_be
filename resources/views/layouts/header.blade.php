@php
    $user = Auth::guard('alumni')->user() ?? Auth::guard('admin')->user();
@endphp
<header class="flex justify-end items-center p-2 bg-white border-b">
    <div class="flex items-center gap-3 pr-4">
        <div class="text-right">
            <p class="font-medium">{{ $user->name }}</p>
            <p class="text-sm text-gray-500">{{ $user->is_admin ? 'Admin' : 'Alumni' }}</p>
        </div>
        @if ($user->is_admin && request()->routeIs('index'))
            <a href="{{ route('admin.dashboard.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg">Admin
                Panel</a>
        @elseif (!$user->is_admin)
            @if (empty($user->photo_profile))
                <span
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-purple-100 border-2 border-purple-300 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                            fill="white" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14c2.21 0 4.21.805 5.879 2.146A9.001 9.001 0 005.121 16.146C7.79 14.805 9.79 14 12 14z" />
                        <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"
                            fill="white" />
                    </svg>
                </span>
            @else
                <img src="{{ asset('storage/' . $user->photo_profile) }}" alt="{{ $user->name }}"
                    class="w-10 h-10 rounded-full" />
            @endif
        @endif
    </div>
</header>
