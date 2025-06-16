<!-- resources/views/users/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Usuario</title>
</head>
<body>
    <h1>Usuario: {{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>Registrado el: {{ $user->created_at->format('d-m-Y') }}</p>
</body>
</html>
