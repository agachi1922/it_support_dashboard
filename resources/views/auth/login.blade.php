<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - IT Support Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: Arial, Helvetica, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 32px;
            border: 1px solid #334155;
            border-radius: 20px;
            background: #1e293b;
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.35);
        }

        h1 {
            margin: 0 0 8px;
            color: #ffffff;
        }

        .subtitle {
            margin: 0 0 28px;
            color: #94a3b8;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
        }

        input {
            width: 100%;
            min-height: 46px;
            margin-bottom: 18px;
            padding: 0 14px;
            border: 1px solid #475569;
            border-radius: 10px;
            background: #0f172a;
            color: #ffffff;
            outline: none;
        }

        input:focus {
            border-color: #3b82f6;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .remember input {
            width: auto;
            min-height: auto;
            margin: 0;
        }

        button {
            width: 100%;
            min-height: 48px;
            border: 0;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            margin-bottom: 18px;
            padding: 12px;
            border: 1px solid #ef4444;
            border-radius: 10px;
            background: rgba(239, 68, 68, 0.12);
            color: #fecaca;
        }
    </style>
</head>

<body>
    <main class="login-card">
        <h1>Login</h1>

        <p class="subtitle">
            Masuk ke IT Support Dashboard.
        </p>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <label for="email">Email</label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                autocomplete="email"
                required
                autofocus
            >

            <label for="password">Password</label>

            <input
                id="password"
                type="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <label class="remember">
                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                >

                Ingat saya
            </label>

            <button type="submit">
                Masuk
            </button>
        </form>
    </main>
</body>
</html>