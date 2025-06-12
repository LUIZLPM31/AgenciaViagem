<?php

require_once 'db.php';

class Viagem {
    private $conn;
    private $table_name = "viagens";

    public $id;
    public $destino;
    public $data_partida;
    public $data_retorno;
    public $preco;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (destino, data_partida, data_retorno, preco) VALUES (:destino, :data_partida, :data_retorno, :preco)";

        $stmt = $this->conn->prepare($query);

        $this->destino = htmlspecialchars(strip_tags($this->destino));
        $this->data_partida = htmlspecialchars(strip_tags($this->data_partida));
        $this->data_retorno = htmlspecialchars(strip_tags($this->data_retorno));
        $this->preco = htmlspecialchars(strip_tags($this->preco));

        $stmt->bindParam(":destino", $this->destino);
        $stmt->bindParam(":data_partida", $this->data_partida);
        $stmt->bindParam(":data_retorno", $this->data_retorno);
        $stmt->bindParam(":preco", $this->preco);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT id, destino, data_partida, data_retorno, preco FROM " . $this->table_name . " ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne() {
        $query = "SELECT id, destino, data_partida, data_retorno, preco FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->destino = $row['destino'];
        $this->data_partida = $row['data_partida'];
        $this->data_retorno = $row['data_retorno'];
        $this->preco = $row['preco'];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET destino = :destino, data_partida = :data_partida, data_retorno = :data_retorno, preco = :preco WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->destino = htmlspecialchars(strip_tags($this->destino));
        $this->data_partida = htmlspecialchars(strip_tags($this->data_partida));
        $this->data_retorno = htmlspecialchars(strip_tags($this->data_retorno));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':destino', $this->destino);
        $stmt->bindParam(':data_partida', $this->data_partida);
        $stmt->bindParam(':data_retorno', $this->data_retorno);
        $stmt->bindParam(':preco', $this->preco);
        $stmt->bindParam(':id', $this->id);

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

