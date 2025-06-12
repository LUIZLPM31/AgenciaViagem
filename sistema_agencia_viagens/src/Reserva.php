<?php

require_once 'db.php';

class Reserva {
    private $conn;
    private $table_name = "reservas";

    public $id;
    public $id_viagem;
    public $id_cliente;
    public $data_reserva;
    public $status;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (id_viagem, id_cliente, data_reserva, status) VALUES (:id_viagem, :id_cliente, :data_reserva, :status)";

        $stmt = $this->conn->prepare($query);

        $this->id_viagem = htmlspecialchars(strip_tags($this->id_viagem));
        $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));
        $this->data_reserva = htmlspecialchars(strip_tags($this->data_reserva));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":id_viagem", $this->id_viagem);
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":data_reserva", $this->data_reserva);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT r.id, r.data_reserva, r.status, v.destino, c.nome as cliente_nome FROM " . $this->table_name . " r LEFT JOIN viagens v ON r.id_viagem = v.id LEFT JOIN clientes c ON r.id_cliente = c.id ORDER BY r.id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne() {
        $query = "SELECT id, id_viagem, id_cliente, data_reserva, status FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id_viagem = $row["id_viagem"];
        $this->id_cliente = $row["id_cliente"];
        $this->data_reserva = $row["data_reserva"];
        $this->status = $row["status"];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET id_viagem = :id_viagem, id_cliente = :id_cliente, data_reserva = :data_reserva, status = :status WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id_viagem = htmlspecialchars(strip_tags($this->id_viagem));
        $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));
        $this->data_reserva = htmlspecialchars(strip_tags($this->data_reserva));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id_viagem", $this->id_viagem);
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":data_reserva", $this->data_reserva);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>

