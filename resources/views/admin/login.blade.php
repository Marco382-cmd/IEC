<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - iBaan Electric</title>
    @vite('resources/css/style.css')
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #2d6a4f 0%, #40916c 100%);
        }
        .login-container {
            background: #fff;
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }
        .login-header p { color: #6b7280; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="{{ asset('images/rb.png') }}" alt="Logo" style="width:80px; margin-bottom:1rem;">
            <h1>Admin Login</h1>
            <p>iBaan Electric Corporation</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                <strong>✕</strong> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required autofocus value="{{ old('username') }}">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <div style="text-align:center; margin-top:2rem;">
            <a href="{{ route('welcome') }}" style="color:#40916c; text-decoration:none; font-weight:500;">
                ← Back to Home
            </a>
        </div>
    </div>
</body>
</html>