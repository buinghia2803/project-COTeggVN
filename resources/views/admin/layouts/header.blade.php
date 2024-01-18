<div class="d-flex justify-content-between align-items-center header">
    <span>
        @if (View::hasSection('title-admin'))
            <h3>
                @yield('title-admin')
            </h3>
        @endif
    </span>
    <div class="btn-group">
        <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-regular fa-circle-user fs-3 p-3"></i>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.home') }}">DASHBOARD</a></li>
            <li><a class="dropdown-item" href="#">Setting</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a></li>
        </ul>
    </div>
</div>
