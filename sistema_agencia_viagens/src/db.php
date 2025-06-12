<?php

class Database {
    private $pdo;

    public function __construct() {
        $databasePath = __DIR__ . '/../database/agencia_viagens.db';
        try {
            $this->pdo = new PDO('sqlite:' . $databasePath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->createTables();
        } catch (PDOException $e) {
            die("Erro de conexão com o banco de dados: " . $e->getMessage());
        }
    }

    private function createTables() {
        $sql = file_get_contents(__DIR__ . '/../database/database.sql');
        if ($sql === false) {
            die("Erro ao ler o arquivo database.sql");
        }
        $this->pdo->exec($sql);
    }

    public function getConnection() {
        return $this->pdo;
    }
}

?>

