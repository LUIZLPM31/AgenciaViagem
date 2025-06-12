<?php
require_once '../src/Reserva.php';
require_once '../src/Viagem.php';
require_once '../src/Cliente.php';

$reserva = new Reserva();
$viagem = new Viagem();
$cliente = new Cliente();
$message = '';

// Processar ações
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $reserva->id_viagem = $_POST['id_viagem'];
                $reserva->id_cliente = $_POST['id_cliente'];
                $reserva->data_reserva = $_POST['data_reserva'];
                $reserva->status = $_POST['status'];
                
                if ($reserva->create()) {
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Reserva cadastrada com sucesso!</div>';
                } else {
                    $message = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Erro ao cadastrar reserva.</div>';
                }
                break;
                
            case 'update':
                $reserva->id = $_POST['id'];
                $reserva->id_viagem = $_POST['id_viagem'];
                $reserva->id_cliente = $_POST['id_cliente'];
                $reserva->data_reserva = $_POST['data_reserva'];
                $reserva->status = $_POST['status'];
                
                if ($reserva->update()) {
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Reserva atualizada com sucesso!</div>';
                } else {
                    $message = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Erro ao atualizar reserva.</div>';
                }
                break;
                
            case 'delete':
                $reserva->id = $_POST['id'];
                if ($reserva->delete()) {
                    $message = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Reserva excluída com sucesso!</div>';
                } else {
                    $message = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Erro ao excluir reserva.</div>';
                }
                break;
        }
    }
}

// Buscar reserva para edição
$editReserva = null;
if (isset($_GET['edit'])) {
    $editReserva = new Reserva();
    $editReserva->id = $_GET['edit'];
    $editReserva->readOne();
}

// Listar todas as reservas
$stmt = $reserva->read();

// Listar viagens e clientes para os selects
$viagensStmt = $viagem->read();
$clientesStmt = $cliente->read();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Reservas - Agência de Viagens</title>
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
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .badge {
            border-radius: 15px;
            padding: 8px 12px;
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
                <a class="nav-link" href="clientes.php"><i class="fas fa-users"></i> Clientes</a>
                <a class="nav-link active" href="reservas.php"><i class="fas fa-calendar-check"></i> Reservas</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-calendar-plus"></i> <?php echo $editReserva ? 'Editar Reserva' : 'Nova Reserva'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="<?php echo $editReserva ? 'update' : 'create'; ?>">
                            <?php if ($editReserva): ?>
                                <input type="hidden" name="id" value="<?php echo $editReserva->id; ?>">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="id_viagem" class="form-label">Viagem</label>
                                <select class="form-select" id="id_viagem" name="id_viagem" required>
                                    <option value="">Selecione uma viagem</option>
                                    <?php 
                                    $viagensStmt = $viagem->read();
                                    while ($viagemRow = $viagensStmt->fetch(PDO::FETCH_ASSOC)): 
                                    ?>
                                        <option value="<?php echo $viagemRow['id']; ?>" 
                                                <?php echo ($editReserva && $editReserva->id_viagem == $viagemRow['id']) ? 'selected' : ''; ?>>
                                            <?php echo $viagemRow['destino'] . ' - ' . date('d/m/Y', strtotime($viagemRow['data_partida'])); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="id_cliente" class="form-label">Cliente</label>
                                <select class="form-select" id="id_cliente" name="id_cliente" required>
                                    <option value="">Selecione um cliente</option>
                                    <?php 
                                    $clientesStmt = $cliente->read();
                                    while ($clienteRow = $clientesStmt->fetch(PDO::FETCH_ASSOC)): 
                                    ?>
                                        <option value="<?php echo $clienteRow['id']; ?>" 
                                                <?php echo ($editReserva && $editReserva->id_cliente == $clienteRow['id']) ? 'selected' : ''; ?>>
                                            <?php echo $clienteRow['nome']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="data_reserva" class="form-label">Data da Reserva</label>
                                <input type="date" class="form-control" id="data_reserva" name="data_reserva" 
                                       value="<?php echo $editReserva ? $editReserva->data_reserva : date('Y-m-d'); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Pendente" <?php echo ($editReserva && $editReserva->status == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                                    <option value="Confirmada" <?php echo ($editReserva && $editReserva->status == 'Confirmada') ? 'selected' : ''; ?>>Confirmada</option>
                                    <option value="Cancelada" <?php echo ($editReserva && $editReserva->status == 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> <?php echo $editReserva ? 'Atualizar' : 'Cadastrar'; ?>
                            </button>
                            
                            <?php if ($editReserva): ?>
                                <a href="reservas.php" class="btn btn-secondary w-100 mt-2">
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
                        <h5><i class="fas fa-list"></i> Lista de Reservas</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Destino</th>
                                        <th>Data Reserva</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['cliente_nome']; ?></td>
                                        <td><?php echo $row['destino']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($row['data_reserva'])); ?></td>
                                        <td>
                                            <?php 
                                            $badgeClass = '';
                                            switch($row['status']) {
                                                case 'Pendente':
                                                    $badgeClass = 'bg-warning';
                                                    break;
                                                case 'Confirmada':
                                                    $badgeClass = 'bg-success';
                                                    break;
                                                case 'Cancelada':
                                                    $badgeClass = 'bg-danger';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?php echo $badgeClass; ?>"><?php echo $row['status']; ?></span>
                                        </td>
                                        <td>
                                            <a href="reservas.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?')">
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

