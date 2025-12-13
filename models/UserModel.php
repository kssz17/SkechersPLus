<?php 
require_once __DIR__ . '/../config/config.php';

class UserModel {
    private $db;
    private $conn; // Propiedad adicional si usas $this->conn en algunos métodos

    public function __construct() {
        // Opción 1: Si config.php tiene getDB()
        $this->db = getDB();
        
        // Opción 2: Si necesitas $this->conn también
        $this->conn = $this->db; // Misma conexión
    }

    // ========== MÉTODOS PARA TABLA 'users' (tu tabla principal) ==========

    // 1. Crear usuario - Para registro
    public function create($nombre, $email, $password, $tipo = 'cliente') {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (nombre, email, password, tipo) VALUES (?, ?, ?, ?)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            return $stmt->execute([$nombre, $email, $hashedPassword, $tipo]);
        } catch (PDOException $e) {
            error_log("Error en create: " . $e->getMessage());
            return false;
        }
    }

    // 2. Obtener usuario CON password - Para login
    public function getUserWithPassword($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getUserWithPassword: " . $e->getMessage());
            return false;
        }
    }

    // 3. Obtener usuario SIN password - Para verificar existencia
    public function getByEmail($email) {
        try {
            $stmt = $this->db->prepare("SELECT id, nombre, email, tipo, created_at FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getByEmail: " . $e->getMessage());
            return false;
        }
    }

    // 4. Verificar contraseña - Método completo
    public function verifyPassword($email, $password) {
        try {
            // 1. Obtener usuario con password
            $user = $this->getUserWithPassword($email);
            
            // 2. Verificar si existe y si tiene password
            if ($user && isset($user['password'])) {
                // 3. Comparar contraseña
                if (password_verify($password, $user['password'])) {
                    // 4. Eliminar password del array por seguridad
                    unset($user['password']);
                    return $user;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en verifyPassword: " . $e->getMessage());
            return false;
        }
    }

    // 5. Listar todos los usuarios
    public function getAll() {
        try {
            $stmt = $this->db->query("SELECT id, nombre, email, tipo, created_at FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getAll: " . $e->getMessage());
            return [];
        }
    }

    // 6. Eliminar usuario
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error en delete: " . $e->getMessage());
            return false;
        }
    }

    // 7. Modificar usuario
    public function update($id, $nombre, $email, $tipo) {
        try {
            $stmt = $this->db->prepare("UPDATE users SET nombre = ?, email = ?, tipo = ? WHERE id = ?");
            return $stmt->execute([$nombre, $email, $tipo, $id]);
        } catch (PDOException $e) {
            error_log("Error en update: " . $e->getMessage());
            return false;
        }
    }

    // 8. Obtener usuario por ID
    public function getById($id) {
        try {
            $stmt = $this->db->prepare("SELECT id, nombre, email, tipo, created_at FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getById: " . $e->getMessage());
            return false;
        }
    }

    // 9. Actualizar password
    public function updatePassword($id, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
            return $stmt->execute([$hashedPassword, $id]);
        } catch (PDOException $e) {
            error_log("Error en updatePassword: " . $e->getMessage());
            return false;
        }
    }

    // ========== MÉTODOS PARA TABLA 'usuarios' (si existe otra tabla) ==========
    // Si realmente tienes DOS tablas diferentes, agrega estos métodos:

    public function getUsuarioWithPassword($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getUsuarioWithPassword: " . $e->getMessage());
            return false;
        }
    }

    public function getUsuarioByEmail($email) {
        try {
            $stmt = $this->db->prepare("SELECT id, nombre, email, created_at FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en getUsuarioByEmail: " . $e->getMessage());
            return false;
        }
    }
}