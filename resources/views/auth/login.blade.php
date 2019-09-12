<form method="POST" action="{{ route('login') }}">
    @csrf

    <label>
        Email:
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
    </label>

    <label>
        Password:
        <input id="password" type="password" name="password" required autocomplete="current-password">
    </label>

    <button>Sign-in</button>
</form>
