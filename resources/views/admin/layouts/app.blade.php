<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - iBaan Electric</title>
      @vite('resources/css/style.css')
      @vite('resources/css/admin.css')
      @vite('resources/css/request-viewer.css')
    
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <img src="{{ asset('images/rb.png') }}" alt="Logo" class="logo-img">
                <h2>iBaan Electric</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="admin-nav">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="admin-nav-icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.requests') }}" class="{{ request()->routeIs('admin.requests*') ? 'active' : '' }}">
                            <span class="admin-nav-icon">📋</span> All Requests
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" style="background:none;border:none;cursor:pointer;width:100%;text-align:left;padding:0;">
                                <a as="button"><span class="admin-nav-icon">🚪</span> Logout</a>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>@yield('page-title')</h1>
                <div class="admin-user">
                    <div class="admin-user-info">
                        <div class="admin-user-name">{{ session('admin_name') }}</div>
                        <div class="admin-user-role">Administrator</div>
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>
</body>
</html>
