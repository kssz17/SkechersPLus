<?php
require_once __DIR__ . '/../config.php';

class ArticuloModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function create($nombre, $precio, $imagen) {
        $stmt = $this->db->prepare("INSERT INTO articulos (nombre, precio, imagen) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $precio, $imagen]);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM articulos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM articulos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nombre, $precio, $imagen) {
        $stmt = $this->db->prepare("UPDATE articulos SET nombre=?, precio=?, imagen=? WHERE id=?");
        return $stmt->execute([$nombre, $precio, $imagen, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM articulos WHERE id=?");
        return $stmt->execute([$id]);
    }
}
