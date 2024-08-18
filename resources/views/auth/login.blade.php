<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    @vite('resources/css/app.css')
        
    <body>
    <div class="container">       
        <!-- Área do Vue.js -->
        <div id="app">
            <login-component></login-component>
        </div>
    </div>


    @vite('resources/js/app.js')
</body>
</html>
