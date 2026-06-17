<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>User Dashboard</title>
</head>

<body>
    <h1>User Dashboard</h1>

    <p>
        Login sebagai: {{ auth()->user()->name }}
    </p>

    <p>
        Role: {{ auth()->user()->role }}
    </p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>
</body>
</html>