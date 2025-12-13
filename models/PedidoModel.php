<?php
require_once __DIR__ . '/../config.php';

class PedidoModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function create($id_usuario, $carrito_json, $total) {
        $stmt = $this->db->prepare("INSERT INTO pedidos (id_usuario, carrito, total) VALUES (?, ?, ?)");
        return $stmt->execute([$id_usuario, $carrito_json, $total]);
    }

    public function getAllByUser($id_usuario) {
        $stmt = $this->db->prepare("SELECT * FROM pedidos WHERE id_usuario=? ORDER BY fecha DESC");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM pedidos ORDER BY fecha DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
