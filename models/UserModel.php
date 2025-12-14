<?php
// models/UserModel.php - VERSIÓN COMPLETA
require_once dirname(__DIR__) . '/config.php';

class UserModel {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
        
        // Verificar conexión
        if (!$this->db) {
            throw new Exception('No se pudo conectar a la base de datos');
        }
    }
    
    /**
     * Crear un nuevo usuario
     */
    public function create($nombre, $email, $password, $tipo = 'cliente') {
        try {
            // Verificar si email ya existe
            $checkStmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $checkStmt->execute([$email]);
            
            if ($checkStmt->fetch()) {
                return false; // Email ya existe
            }
            
            // Insertar nuevo usuario
            $stmt = $this->db->prepare("
                INSERT INTO users (nombre, email, password, tipo, created_at) 
                VALUES (?, ?, ?, ?, NOW())
            ");
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            return $stmt->execute([$nombre, $email, $hashedPassword, $tipo]);
            
        } catch (PDOException $e) {
            error_log("UserModel::create Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener usuario con contraseña (para login)
     */
    public function getUserWithPassword($email) {
        try {
            $stmt = $this->db->prepare("
                SELECT id, nombre, email, password, tipo, created_at 
                FROM users 
                WHERE email = ?
            ");
            
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("UserModel::getUserWithPassword Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener usuario por ID (sin contraseña)
     */
    public function getUserById($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT id, nombre, email, tipo, created_at 
                FROM users 
                WHERE id = ?
            ");
            
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("UserModel::getUserById Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verificar si un email existe
     */
    public function emailExists($email) {
        try {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch() !== false;
            
        } catch (PDOException $e) {
            error_log("UserModel::emailExists Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar usuario
     */
    public function update($id, $data) {
        try {
            // Construir consulta dinámica
            $fields = [];
            $params = [];
            
            foreach ($data as $key => $value) {
                if ($key === 'password' && !empty($value)) {
                    $fields[] = "password = ?";
                    $params[] = password_hash($value, PASSWORD_DEFAULT);
                } elseif ($key !== 'id') {
                    $fields[] = "$key = ?";
                    $params[] = $value;
                }
            }
            
            if (empty($fields)) {
                return false;
            }
            
            $params[] = $id;
            $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
            
        } catch (PDOException $e) {
            error_log("UserModel::update Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Eliminar usuario
     */
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
            
        } catch (PDOException $e) {
            error_log("UserModel::delete Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Listar todos los usuarios (para admin)
     */
    public function getAllUsers($limit = 100) {
        try {
            $stmt = $this->db->prepare("
                SELECT id, nombre, email, tipo, created_at 
                FROM users 
                ORDER BY created_at DESC 
                LIMIT ?
            ");
            
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("UserModel::getAllUsers Error: " . $e->getMessage());
            return [];
        }
    }
}