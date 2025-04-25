<x-guest-layout>
    <h4 class="fw-semibold mb-2">Login to your account</h4>
    <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>

    <form method="POST" action="{{ route('login') }}" class="text-start mb-3">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
            @error('email')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required autocomplete="current-password">
            @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
        </div>

        <div class="d-flex justify-content-between mb-3">
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-muted border-bottom border-dashed">Forgot Password?</a>
            @endif
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</x-guest-layout>
