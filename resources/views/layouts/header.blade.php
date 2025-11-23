<header class="flex justify-end items-center p-2 bg-white border-b">
    <div class="flex items-center gap-3 pr-4">
        <div class="text-right">
            <p class="font-medium">{{ auth()->user()->name }}</p>
            <p class="text-sm text-gray-500">Admin</p>
        </div>
        <img src="https://i.pravatar.cc/50?img=12" alt="" class="w-10 h-10 rounded-full" />
        {{-- <img src="{{ asset('storage/' . auth()->user()->photo_profile) }}"alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full" /> --}}
    </div>
</header>

