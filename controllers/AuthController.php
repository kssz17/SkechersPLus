<?php
// controllers/AuthController.php

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function register($data) {
        try {
            // Validaciones
            if (empty($data['nombre']) || empty($data['email']) || empty($data['password'])) {
                return ['success' => false, 'message' => 'Todos los campos son obligatorios'];
            }
            
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'Email no válido'];
            }
            
            if (strlen($data['password']) < 6) {
                return ['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres'];
            }
            
            if ($data['password'] !== $data['confirmPassword']) {
                return ['success' => false, 'message' => 'Las contraseñas no coinciden'];
            }
            
            // Verificar si ya existe
            $existingUser = $this->userModel->getByEmail($data['email']);
            if ($existingUser) {
                return ['success' => false, 'message' => 'El email ya está registrado'];
            }
            
            // Crear usuario
            $result = $this->userModel->create(
                $data['nombre'],
                $data['email'],
                $data['password'],
                'cliente' // Tipo por defecto
            );
            
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Usuario registrado exitosamente'
                ];
            } else {
                return ['success' => false, 'message' => 'Error al registrar usuario'];
            }
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    public function login($email, $password) {
        try {
            // Validaciones básicas
            if (empty($email) || empty($password)) {
                return ['success' => false, 'message' => 'Email y contraseña son obligatorios'];
            }
            
            // Usar verifyPassword del UserModel
            $user = $this->userModel->verifyPassword($email, $password);
            
            if (!$user) {
                return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
            }
            
            // Iniciar sesión
            @session_start();
            
            // Guardar usuario en sesión
            $_SESSION['user'] = $user;
            
            return [
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'user' => $user
            ];
            
        } catch (Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el servidor'];
        }
    }
    
    public function logout() {
        @session_start();
        session_destroy();
        return ['success' => true, 'message' => 'Sesión cerrada'];
    }
}