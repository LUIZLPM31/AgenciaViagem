<?php
require_once '../src/Viagem.php';

$viagem = new Viagem();
$message = '';

// Processar ações
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $viagem->destino = $_POST['destino'];
                $viagem->data_partida = $_POST['data_partida'];
                $viagem->data_retorno = $_POST['data_retorno'];
                $viagem->preco = $_POST['preco'];
                
                if ($viagem->create()) {
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Viagem cadastrada com sucesso!</div>';
                } else {
                    $message = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Erro ao cadastrar viagem.</div>';
                }
                break;
                
            case 'update':
                $viagem->id = $_POST['id'];
                $viagem->destino = $_POST['destino'];
                $viagem->data_partida = $_POST['data_partida'];
                $viagem->data_retorno = $_POST['data_retorno'];
                $viagem->preco = $_POST['preco'];
                
                if ($viagem->update()) {
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Viagem atualizada com sucesso!</div>';
                } else {
                    $message = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Erro ao atualizar viagem.</div>';
                }
                break;
                
            case 'delete':
                $viagem->id = $_POST['id'];
                if ($viagem->delete()) {
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Viagem excluída com sucesso!</div>';
                } else {
                    $message = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Erro ao excluir viagem.</div>';
                }
                break;
        }
    }
}

// Buscar viagem para edição
$editViagem = null;
if (isset($_GET['edit'])) {
    $editViagem = new Viagem();
    $editViagem->id = $_GET['edit'];
    $editViagem->readOne();
}

// Listar todas as viagens
$stmt = $viagem->read();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Viagens - Agência de Viagens</title>
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
                <a class="nav-link active" href="viagens.php"><i class="fas fa-map-marked-alt"></i> Viagens</a>
                <a class="nav-link" href="clientes.php"><i class="fas fa-users"></i> Clientes</a>
                <a class="nav-link" href="reservas.php"><i class="fas fa-calendar-check"></i> Reservas</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-plus-circle"></i> <?php echo $editViagem ? 'Editar Viagem' : 'Nova Viagem'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="<?php echo $editViagem ? 'update' : 'create'; ?>">
                            <?php if ($editViagem): ?>
                                <input type="hidden" name="id" value="<?php echo $editViagem->id; ?>">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="destino" class="form-label">Destino</label>
                                <input type="text" class="form-control" id="destino" name="destino" 
                                       value="<?php echo $editViagem ? $editViagem->destino : ''; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="data_partida" class="form-label">Data de Partida</label>
                                <input type="date" class="form-control" id="data_partida" name="data_partida" 
                                       value="<?php echo $editViagem ? $editViagem->data_partida : ''; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="data_retorno" class="form-label">Data de Retorno</label>
                                <input type="date" class="form-control" id="data_retorno" name="data_retorno" 
                                       value="<?php echo $editViagem ? $editViagem->data_retorno : ''; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço (R$)</label>
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco" 
                                       value="<?php echo $editViagem ? $editViagem->preco : ''; ?>" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> <?php echo $editViagem ? 'Atualizar' : 'Cadastrar'; ?>
                            </button>
                            
                            <?php if ($editViagem): ?>
                                <a href="viagens.php" class="btn btn-secondary w-100 mt-2">
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
                        <h5><i class="fas fa-list"></i> Lista de Viagens</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Destino</th>
                                        <th>Partida</th>
                                        <th>Retorno</th>
                                        <th>Preço</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['destino']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($row['data_partida'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($row['data_retorno'])); ?></td>
                                        <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                                        <td>
                                            <a href="viagens.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir esta viagem?')">
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

