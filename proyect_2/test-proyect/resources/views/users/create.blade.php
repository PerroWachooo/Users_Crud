<!-- resources/views/users/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Crear Usuario</title>
</head>
<body>
    <div id="app" data-vue-component="UserForm"></div> <!-- Este es el contenedor donde Vue montará el componente -->

    <!-- Incluye el archivo JS compilado -->
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
