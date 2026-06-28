<!DOCTYPE html>
<html>
<head>
    <title>Login - Vandeesa System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(123, 92, 219, 0.3);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo {
            font-size: 48px;
            font-weight: 700;
            color: #7C5CDB;
            margin-bottom: 10px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 14px;
            color: #9CA3AF;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #E9D5FF;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #7C5CDB;
            box-shadow: 0 0 0 3px rgba(123, 92, 219, 0.1);
        }

        .form-group input::placeholder {
            color: #D1D5DB;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            color: #991B1B;
            border-left: 4px solid #EF4444;
        }

        .alert-success {
            background: linear-gradient(135deg, #DCFCE7 0%, #D1FAE5 100%);
            color: #166534;
            border-left: 4px solid #10B981;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(123, 92, 219, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-divider {
            text-align: center;
            margin: 30px 0 20px 0;
            font-size: 14px;
            color: #9CA3AF;
        }

        .demo-info {
            background: #F5F3FF;
            border: 1px solid #E9D5FF;
            border-radius: 8px;
            padding: 16px;
            margin-top: 20px;
            font-size: 13px;
            line-height: 1.6;
        }

        .demo-info strong {
            color: #6B46C1;
            display: block;
            margin-bottom: 8px;
        }

        .demo-user {
            background: white;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 8px;
            font-family: 'Courier New', monospace;
        }

        .demo-user:last-child {
            margin-bottom: 0;
        }

        .demo-label {
            font-size: 11px;
            color: #7C5CDB;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
            margin-right: 6px;
        }

        .error-icon {
            display: none;
            color: #EF4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .form-group.has-error input {
            border-color: #EF4444;
            background: #FEF2F2;
        }

        .form-group.has-error .error-icon {
            display: block;
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">V</div>
            <h1 class="login-title">Vandeesa System</h1>
            <p class="login-subtitle">Sistem Manajemen Penjualan</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group @error('username') has-error @enderror">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan username"
                    value="{{ old('username') }}"
                    required
                    autofocus
                >
                @error('username')
                    <div class="error-icon">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('password') has-error @enderror">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
                @error('password')
                    <div class="error-icon">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-button">
                🔓 Masuk
            </button>
        </form>

        <div class="login-divider">Akun Demo</div>

        <div class="demo-info">
            <strong>Silakan gunakan akun berikut untuk testing:</strong>

            <div class="demo-user">
                <span class="demo-label">Admin</span><br>
                Username: admin | Password: password
            </div>

            <div class="demo-user">
                <span class="demo-label">Kasir</span><br>
                Username: kasir | Password: password
            </div>

            <div class="demo-user">
                <span class="demo-label">Owner</span><br>
                Username: owner | Password: password
            </div>
        </div>
    </div>
</div>

<script>
    // Add focus animation
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'all 0.3s ease';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });

    // Form submit animation
    document.querySelector('form').addEventListener('submit', function(e) {
        const button = this.querySelector('button');
        button.style.opacity = '0.7';
        button.style.transform = 'scale(0.98)';
    });
</script>

</body>
</html>
