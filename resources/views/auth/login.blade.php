<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — TK Puspitasari</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #e8f5f1 0%, #f8fdfb 50%, #e0f2ec 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(76, 175, 147, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }

        .auth-header {
            background: linear-gradient(135deg, #2d6a4f, #4CAF93);
            padding: 36px 32px 28px;
            text-align: center;
        }

        .auth-header .logo {
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 28px;
            color: #fff;
        }

        .auth-header h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .auth-header p {
            color: rgba(255,255,255,.8);
            font-size: 13px;
            margin: 0;
        }

        .auth-body { padding: 32px; }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e0e0e0;
            padding: 11px 14px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus {
            border-color: #4CAF93;
            box-shadow: 0 0 0 3px rgba(76,175,147,.15);
            outline: none;
        }

        .input-icon-wrap { position: relative; }
        .input-icon-wrap .bi {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 16px;
        }
        .input-icon-wrap .form-control { padding-left: 38px; }

        .btn-auth {
            width: 100%;
            background: linear-gradient(135deg, #4CAF93, #2d6a4f);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: opacity .2s, transform .2s;
            margin-top: 8px;
        }
        .btn-auth:hover { opacity: .92; transform: translateY(-1px); }

        .auth-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
            color: #aaa;
            font-size: 12px;
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #eee;
        }
        .auth-divider::before { left: 0; }
        .auth-divider::after  { right: 0; }

        .auth-link {
            display: block;
            text-align: center;
            font-size: 13px;
            color: #555;
        }
        .auth-link a { color: #4CAF93; font-weight: 600; text-decoration: none; }
        .auth-link a:hover { text-decoration: underline; }

        .alert { border-radius: 10px; font-size: 13px; }

        .form-check-label { font-size: 13px; color: #666; }
        .form-check-input:checked { background-color: #4CAF93; border-color: #4CAF93; }
    </style>
</head>
<body>

<div class="auth-card">

    <!-- Header -->
    <div class="auth-header">
        <div class="logo"><i class="bi bi-mortarboard-fill"></i></div>
        <h1>Selamat Datang</h1>
        <p>Masuk ke Portal PPDB TK Puspitasari</p>
    </div>

    <!-- Body -->
    <div class="auth-body">

        {{-- Flash error dari logout / lainnya --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Error credentials --}}
        @if($errors->has('email'))
            <div class="alert alert-danger mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first('email') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-envelope"></i>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="contoh@email.com"
                           autocomplete="email"
                           autofocus>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label mb-0">Password</label>
                </div>
                <div class="input-icon-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••"
                           autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Remember Me -->
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="btn-auth">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        <div class="auth-divider mt-4">atau</div>

        <p class="auth-link">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar Akun Baru</a>
        </p>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
