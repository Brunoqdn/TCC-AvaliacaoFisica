<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesquisar Pessoa</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div id="app">
        <pesquisar-pessoa></pesquisar-pessoa>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
