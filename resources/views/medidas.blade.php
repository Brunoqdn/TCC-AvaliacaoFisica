<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inserir Medida</title>
    @vite('resources/css/app.css')


</head>
<body>
    <div class="container">
        <h1>Inserir Medida</h1>
        
        <!-- Área do Vue.js -->
        <div id="app">
            <formulario-medida></formulario-medida>
    
        </div>
    </div>
    @vite('resources/js/app.js')

</body>
</html>
