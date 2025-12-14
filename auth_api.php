<?php
// auth_api.php - VERSIÓN SIMPLIFICADA Y FUNCIONAL
session_start();
header('Content-Type: application/json');

// Activar errores para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Verificar método
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }
    
    // Obtener acción
    $action = $_POST['action'] ?? '';
    
    // Cargar config y UserModel directamente
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/models/UserModel.php';
    
    $userModel = new UserModel();
    
    switch ($action) {
        case 'login':
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Validaciones básicas
            if (empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
            
            // Buscar usuario
            $user = $userModel->getUserWithPassword($email);
            
            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
                exit;
            }
            
            // Verificar contraseña
            if (password_verify($password, $user['password'])) {
                // Iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_type'] = $user['tipo'] ?? 'cliente';
                $_SESSION['logged_in'] = true;
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Login exitoso',
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['nombre'],
                        'email' => $user['email']
                    ]
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
            }
            break;
            
        case 'register':
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirmPassword'] ?? '';
            
            // Validaciones
            if (empty($nombre) || empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
            
            if ($password !== $confirm) {
                echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
                exit;
            }
            
            // Verificar si usuario ya existe
            $existing = $userModel->getUserWithPassword($email);
            if ($existing) {
                echo json_encode(['success' => false, 'message' => 'El email ya está registrado']);
                exit;
            }
            
            // Crear usuario
            $result = $userModel->create($nombre, $email, $password);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Registro exitoso. Ahora puedes iniciar sesión.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor',
        'debug' => $e->getMessage() // Solo para desarrollo
    ]);
}