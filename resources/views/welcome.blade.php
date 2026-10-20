<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            <h1>Gestion des Archives</h1>
            <p>L'application est prête. Bootstrap fonctionne correctement.</p>
        </div>
        <button class="btn btn-primary">Test Bootstrap</button>
    </div>
</body>
</html>