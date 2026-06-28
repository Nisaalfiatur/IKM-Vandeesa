@extends('layouts.app')

@section('content')
<style>
    .login-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 9999;
        background: linear-gradient(135deg, #F5F3FF 0%, #EBE7FA 100%);
        overflow-y: auto;
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        box-sizing: border-box;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(139, 124, 246, 0.15);
        border-radius: 24px;
        padding: 40px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 10px 40px rgba(139, 124, 246, 0.08), 0 2px 10px rgba(139, 124, 246, 0.04);
        animation: floatUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
        color: #2D2555;
    }

    @keyframes floatUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .glass-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .logo-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #A78BFA, #8B7CF6);
        border-radius: 18px;
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(139, 124, 246, 0.25);
        animation: float 3s ease-in-out infinite;
        color: #fff;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .glass-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #221B47;
    }

    .glass-subtitle {
        font-size: 14.5px;
        color: #7E76A3;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #62598F;
    }

    .glass-input {
        width: 100%;
        padding: 13px 16px;
        background: #fff;
        border: 2px solid rgba(139, 124, 246, 0.15);
        border-radius: 12px;
        font-size: 14.5px;
        color: #221B47;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .glass-input::placeholder {
        color: #A59EBF;
    }

    .glass-input:focus {
        outline: none;
        border-color: #8B7CF6;
        box-shadow: 0 0 0 3px rgba(139, 124, 246, 0.12);
    }

    .glass-input.is-invalid {
        border-color: #EF4444;
        background: #FFF5F5;
    }

    .error-text {
        color: #EF4444;
        font-size: 12.5px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
    }

    .glass-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #A78BFA, #8B7CF6);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-top: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(139, 124, 246, 0.25);
    }

    .glass-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 124, 246, 0.4);
    }

    .glass-btn:active {
        transform: translateY(0);
    }

    .alert-glass {
        padding: 12px 14px;
        border-radius: 12px;
        margin-bottom: 1.25rem;
        font-size: 13.5px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }

    .alert-error {
        background: #FFF5F5;
        border: 1px solid #FED7D7;
        color: #C53030;
    }

    .alert-success {
        background: #F0FDF4;
        border: 1px solid #C6F6D5;
        color: #22543D;
    }
</style>

<div class="login-wrapper">
    <div class="login-container">
        <div class="glass-card">
            <div class="glass-header">
                <img src="{{ asset('images/items/LOGO VANDEESA.png') }}" alt="Vandeesa Logo" style="width: 200px; height: auto; margin-bottom: 1rem; animation: float 3s ease-in-out infinite;">
                

            @if(session('error'))
                <div class="alert-glass alert-error">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert-glass alert-success">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="username" class="form-label">Username 👤</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="glass-input @error('username') is-invalid @enderror"
                        placeholder="Masukkan username..."
                        value="{{ old('username') }}"
                        required
                        autofocus
                    >
                    @error('username')
                        <div class="error-text">❌ {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password 🔒</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="glass-input @error('password') is-invalid @enderror"
                        placeholder="Masukkan password..."
                        required
                    >
                    @error('password')
                        <div class="error-text">❌ {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="glass-btn">
                    Masuk 🚀
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const btn = this.querySelector('button');
        btn.innerHTML = 'Memproses... ⏳';
        btn.style.opacity = '0.8';
        btn.style.transform = 'scale(0.98)';
    });
</script>
@endsection
