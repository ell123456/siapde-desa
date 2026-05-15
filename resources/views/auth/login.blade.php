<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIAPDE</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-body: #f4f7fe;
            --navy-blue: #1e3a8a;
            --neon-cyan: #22d3ee;
            --text-gray: #64748b;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            background-image:
                radial-gradient(at 0% 0%, rgba(34, 211, 238, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(30, 58, 138, 0.05) 0px, transparent 50%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* KOTAK LOGIN DENGAN NEON TIPIS (SINKRON DENGAN SIDEBAR) */
        .login-box {
            background: white;
            padding: 50px 40px;
            border-radius: 28px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid rgba(34, 211, 238, 0.2);
            position: relative;
            /* Efek Neon Shadow di 4 Sudut */
            box-shadow:
                -15px -15px 35px rgba(34, 211, 238, 0.07),
                15px -15px 35px rgba(34, 211, 238, 0.07),
                -15px 15px 35px rgba(34, 211, 238, 0.07),
                15px 15px 35px rgba(34, 211, 238, 0.07),
                0 10px 25px rgba(30, 58, 138, 0.05);
            animation: slideUp 0.8s ease-out;
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

        .login-box img {
            width: 80px;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 8px rgba(34, 211, 238, 0.3));
        }

        .login-box h2 {
            margin: 0 0 10px 0;
            color: var(--navy-blue);
            font-weight: 800;
            font-size: 24px;
            letter-spacing: -0.5px;
        }

        .login-box p {
            color: var(--text-gray);
            font-size: 13px;
            margin-bottom: 35px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-left: 5px;
        }

        /* INPUT FIELD DENGAN FOCUS NEON */
        .form-group input {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-sizing: border-box;
            font-family: 'Poppins';
            font-size: 14px;
            transition: 0.3s;
            background: #fcfdfe;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--neon-cyan);
            box-shadow: 0 0 12px rgba(34, 211, 238, 0.2);
            background: white;
        }

        /* TOMBOL LOGIN GRADIENT NEON */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #22d3ee 0%, #0ea5e9 100%);
            border: none;
            color: white;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 6px 20px rgba(34, 211, 238, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(34, 211, 238, 0.4);
            filter: brightness(1.05);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .error {
            background: #fef2f2;
            color: #ef4444;
            padding: 12px;
            border-radius: 12px;
            font-size: 12px;
            margin-bottom: 20px;
            border: 1px solid #fee2e2;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }

        /* Watermark Background halus */
        .bg-icon {
            position: absolute;
            font-size: 200px;
            color: rgba(30, 58, 138, 0.02);
            z-index: -1;
            bottom: -50px;
            left: -50px;
            transform: rotate(-15deg);
        }
    </style>
</head>

<body>
    <div class="login-box">
        <i class="fas fa-landmark bg-icon"></i>

        <img src="{{ asset('logo-desa.png') }}" alt="Logo">
        <h2>MASUK SIAPDE</h2>
        <p>Sistem Informasi Administrasi Desa Digital</p>

        @if($errors->any())
        <div class="error">
            <i class="fas fa-exclamation-circle"></i>
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label><i class="fas fa-user-circle mr-1"></i> Username</label>
                <input type="text" name="username" required placeholder="Masukkan Username" value="{{ old('username') }}" autofocus>
            </div>

            <div class="form-group">
                <label><i class="fas fa-lock mr-1"></i> Kata Sandi</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-login">Masuk Sekarang</button>
        </form>

        <div style="margin-top: 30px; font-size: 11px; color: #cbd5e1; font-weight: 500;">
            &copy; {{ date('Y') }} Pemerintah Desa {{ $profil->nama_desa ?? '' }}
        </div>
    </div>
</body>

</html>