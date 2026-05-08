<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — TK Puspitasari</title>
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
            padding: 24px 16px;
        }

        .auth-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(76, 175, 147, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 460px;
        }

        .auth-header {
            background: linear-gradient(135deg, #2d6a4f, #4CAF93);
            padding: 32px 32px 24px;
            text-align: center;
        }

        .auth-header .logo {
            width: 68px;
            height: 68px;
            background: rgba(255,255,255,.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            font-size: 26px;
            color: #fff;
        }

        .auth-header h1 { color:#fff; font-size:21px; font-weight:700; margin:0 0 4px; }
        .auth-header p  { color:rgba(255,255,255,.8); font-size:13px; margin:0; }

        .auth-body { padding: 28px 32px 32px; }

        .form-label { font-size:13px; font-weight:600; color:#444; margin-bottom:6px; }

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
        .form-control.is-invalid { border-color: #dc3545; }

        .input-icon-wrap { position: relative; }
        .input-icon-wrap .bi {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 16px;
            pointer-events: none;
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
            margin-top: 4px;
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

        .auth-link { display:block; text-align:center; font-size:13px; color:#555; }
        .auth-link a { color:#4CAF93; font-weight:600; text-decoration:none; }
        .auth-link a:hover { text-decoration:underline; }

        .alert { border-radius: 10px; font-size: 13px; }

        .invalid-feedback { font-size: 12px; }

        .hint-text { font-size: 11px; color: #aaa; margin-top: 4px; }
    </style>
</head>
<body>

<div class="auth-card">

    <!-- Header -->
    <div class="auth-header">
        <div class="logo"><i class="bi bi-person-plus-fill"></i></div>
        <h1>Buat Akun Baru</h1>
        <p>Portal PPDB TK Puspitasari {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <!-- Body -->
    <div class="auth-body">

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Periksa kembali data Anda:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap (Orang Tua/Wali)</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-person"></i>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Nama lengkap sesuai KTP"
                           autocomplete="name"
                           autofocus>
                </div>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <p class="hint-text">Nama ini akan digunakan sebagai identitas akun Anda.</p>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email Aktif</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-envelope"></i>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="contoh@gmail.com"
                           autocomplete="email">
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <p class="hint-text">Gunakan email aktif. Email ini akan dipakai untuk login.</p>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimal 8 karakter"
                           autocomplete="new-password">
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-lock-fill"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-control"
                           placeholder="Ketik ulang password Anda"
                           autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn-auth">
                <i class="bi bi-person-check me-2"></i>Buat Akun & Mulai Daftar
            </button>
        </form>

        <div class="auth-divider mt-4">sudah punya akun?</div>

        <p class="auth-link">
            <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Masuk ke akun Anda</a>
        </p>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
