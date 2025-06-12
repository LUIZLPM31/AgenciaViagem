<?php
require_once '../src/Cliente.php';

$cliente = new Cliente();
$message = '';

// Processar ações
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $cliente->nome = $_POST['nome'];
                $cliente->email = $_POST['email'];
                $cliente->telefone = $_POST['telefone'];
                
                if ($cliente->create()) {
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Cliente cadastrado com sucesso!</div>';
                } else {
                    $message = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Erro ao cadastrar cliente.</div>';
                }
                break;
                
            case 'update':
                $cliente->id = $_POST['id'];
                $cliente->nome = $_POST['nome'];
                $cliente->email = $_POST['email'];
                $cliente->telefone = $_POST['telefone'];
                
                if ($cliente->update()) {
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Cliente atualizado com sucesso!</div>';
                } else {
                    $message = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Erro ao atualizar cliente.</div>';
                }
                break;
                
            case 'delete':
                $cliente->id = $_POST['id'];
                if ($cliente->delete()) {
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Cliente excluído com sucesso!</div>';
                } else {
                    $message = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Erro ao excluir cliente.</div>';
                }
                break;
        }
    }
}

// Buscar cliente para edição
$editCliente = null;
if (isset($_GET['edit'])) {
    $editCliente = new Cliente();
    $editCliente->id = $_GET['edit'];
    $editCliente->readOne();
}

// Listar todos os clientes
$stmt = $cliente->read();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Clientes - Agência de Viagens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
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
            padding: 8px 20px;
        }
        
        .btn-warning {
            background: linear-gradient(45deg, #f093fb, #f5576c);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
        }
        
        .btn-danger {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
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
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-plane"></i> Agência de Viagens
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Início</a>
                <a class="nav-link" href="viagens.php"><i class="fas fa-map-marked-alt"></i> Viagens</a>
                <a class="nav-link active" href="clientes.php"><i class="fas fa-users"></i> Clientes</a>
                <a class="nav-link" href="reservas.php"><i class="fas fa-calendar-check"></i> Reservas</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-user-plus"></i> <?php echo $editCliente ? 'Editar Cliente' : 'Novo Cliente'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="<?php echo $editCliente ? 'update' : 'create'; ?>">
                            <?php if ($editCliente): ?>
                                <input type="hidden" name="id" value="<?php echo $editCliente->id; ?>">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" 
                                       value="<?php echo $editCliente ? $editCliente->nome : ''; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo $editCliente ? $editCliente->email : ''; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" 
                                       value="<?php echo $editCliente ? $editCliente->telefone : ''; ?>">
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> <?php echo $editCliente ? 'Atualizar' : 'Cadastrar'; ?>
                            </button>
                            
                            <?php if ($editCliente): ?>
                                <a href="clientes.php" class="btn btn-secondary w-100 mt-2">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <?php echo $message; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-list"></i> Lista de Clientes</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Telefone</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['nome']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['telefone']; ?></td>
                                        <td>
                                            <a href="clientes.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

