CREATE TABLE IF NOT EXISTS viagens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    destino TEXT NOT NULL,
    data_partida TEXT NOT NULL,
    data_retorno TEXT NOT NULL,
    preco REAL NOT NULL
);

CREATE TABLE IF NOT EXISTS clientes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    telefone TEXT
);

CREATE TABLE IF NOT EXISTS reservas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_viagem INTEGER NOT NULL,
    id_cliente INTEGER NOT NULL,
    data_reserva TEXT NOT NULL,
    status TEXT NOT NULL,
    FOREIGN KEY (id_viagem) REFERENCES viagens(id),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
);

