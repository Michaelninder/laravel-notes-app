<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - {{ config('app.name') }}</title>
</head>
<body>
    <main>
        <h1>Forgot Password</h1>

        <p>
            Forgot your password? No problem. Just let us know your email 
            address and we will email you a password reset link.
        </p>

        @if (session('status'))
            <div>{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <label for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus>
            </div>

            <div>
                <button type="submit">Email Password Reset Link</button>
                <a href="{{ route('login') }}">Back to login</a>
            </div>
        </form>
    </main>
</body>
</html>