<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
</head>
<body>
    <main>
        <h1>Login</h1>

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

        <form method="POST" action="{{ route('login') }}">
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
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required>
            </div>

            <div>
                <label>
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
            </div>

            <div>
                <button type="submit">Log in</button>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>
        </form>

        <p>
            Don't have an account? 
            <a href="{{ route('register') }}">Register</a>
        </p>
    </main>
</body>
</html>