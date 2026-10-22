@extends('layouts.guest')

@section('title', "Connexion")

@section('content')
<main class="auth-card card">
    <div class="card-body p-4 p-sm-5">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/logo.svg') }}" alt="" width="52" height="52">
            <h1 class="h4 mt-3 mb-1">Connexion</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <p class="text-muted">Accédez à votre espace de gestion des archives</p>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Adresse e-mail</label>
                <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required autocomplete="username"
                autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Mot de passe</label>
                <div class="input-group">
                    <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    required minlength="8"
                    autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <button
                        class="btn btn-outline-secondary"
                        type="button"
                        data-toggle-password="#password"
                        aria-label="Afficher le mot de passe">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input
                    class="form-check-input"
                    type="checkbox"
                    id="remember">
                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>
                <a href="{{ route('password.request') }}" >Mot de passe oublié ?</a>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Se connecter</button>
        </form>
    </div>
</main>
@endsection
