<header class="navbar-top"><div class="container-fluid d-flex justify-content-between align-items-center"><a class="navbar-brand mb-0"href="{{ url('/') }}">Alumni SV</a>@if (auth()->check()) <div class="user-header-info d-flex align-items-center gap-2">@if (auth()->user()->photo_profile) <img src="{{ asset('storage/' . auth()->user()->photo_profile) }}"alt="{{ auth()->user()->name }}"
class="user-header-photo rounded-circle"style="width: 40px; height: 40px; object-fit: cover;">@else <div class="user-header-photo rounded-circle bg-light d-flex align-items-center justify-content-center"

style="width: 40px; height: 40px;"><i data-feather="user"style="width: 20px; height: 20px; color: #95a3b3;"></i></div>@endif <div class="user-header-text"><div class="user-header-name"> {{auth()->user()->name}}

</div><div class="user-header-role">Admin</div></div></div>@endif </div></header>
