<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agência de Viagens - Sistema de Gerenciamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-image: "data:image/jpeg;base64,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";
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: #667eea !important;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(45deg, #56ab2f, #a8e6cf);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
        }
        
        .btn-warning {
            background: linear-gradient(45deg, #f093fb, #f5576c);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
        }
        
        .btn-danger {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
        }
        
        .hero-section {
            text-align: center;
            color: white;
            padding: 60px 0;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }
        
        .feature-card {
            text-align: center;
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .table thead {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-plane"></i> Agência de Viagens
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="viagens.php"><i class="fas fa-map-marked-alt"></i> Viagens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="clientes.php"><i class="fas fa-users"></i> Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservas.php"><i class="fas fa-calendar-check"></i> Reservas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="margin-top: 76px;">
        <div class="hero-section">
            <div class="container">
                <h1 class="hero-title">Sistema de Gerenciamento</h1>
                <p class="hero-subtitle">Gerencie viagens, clientes e reservas de forma eficiente</p>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h4>Gerenciar Viagens</h4>
                        <p>Cadastre e gerencie destinos, datas e preços das viagens disponíveis.</p>
                        <a href="viagens.php" class="btn btn-primary">
                            <i class="fas fa-arrow-right"></i> Acessar
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Gerenciar Clientes</h4>
                        <p>Mantenha um cadastro completo de todos os seus clientes.</p>
                        <a href="clientes.php" class="btn btn-primary">
                            <i class="fas fa-arrow-right"></i> Acessar
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4>Gerenciar Reservas</h4>
                        <p>Controle todas as reservas realizadas pelos clientes.</p>
                        <a href="reservas.php" class="btn btn-primary">
                            <i class="fas fa-arrow-right"></i> Acessar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

