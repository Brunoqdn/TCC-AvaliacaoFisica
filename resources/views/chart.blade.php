<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminLTE Gráfico</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Importar o CSS do AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <!-- Importar o CSS do Vue (se necessário) -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar (opcional) -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div id="app">
                        <h1>Gráfico AdminLTE</h1>
                        <!-- Aqui será montado o componente Vue com o gráfico -->
                        <chart-component></chart-component>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer (opcional) -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024.</strong>
        </footer>
    </div>

    <!-- Importar JS do Vue e AdminLTE -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
