<?php
// auth_api.php - VERSIÓN SIN ERRORES

// 1. Desactivar TODA salida HTML de errores
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0); // Temporalmente desactivado

// 2. Crear archivo de log para debug
$logFile = __DIR__ . '/auth_debug.log';
file_put_contents($logFile, "\n" . date('Y-m-d H:i:s') . " === INICIO ===\n", FILE_APPEND);

// 3. Establecer headers PRIMERO
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// 4. Función para manejar errores consistentemente
function sendError($message) {
    global $logFile;
    $response = ['success' => false, 'message' => $message];
    file_put_contents($logFile, "ERROR: $message\n", FILE_APPEND);
    echo json_encode($response);
    exit;
}

// 5. Función para éxito
function sendSuccess($message, $extraData = []) {
    global $logFile;
    $response = array_merge(['success' => true, 'message' => $message], $extraData);
    file_put_contents($logFile, "SUCCESS: $message\n", FILE_APPEND);
    echo json_encode($response);
    exit;
}

try {
    // 6. Verificar método
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendError('Método no permitido. Usa POST.');
    }
    
    file_put_contents($logFile, "Método: POST\n", FILE_APPEND);
    
    // 7. Verificar acción
    if (!isset($_POST['action'])) {
        sendError('Acción no especificada');
    }
    
    $action = $_POST['action'];
    file_put_contents($logFile, "Acción: $action\n", FILE_APPEND);
    file_put_contents($logFile, "POST data: " . print_r($_POST, true) . "\n", FILE_APPEND);
    
    // 8. Cargar archivos con manejo de errores
    $baseDir = __DIR__;
    
    // UserModel
    $userModelPath = $baseDir . '/models/UserModel.php';
    if (!file_exists($userModelPath)) {
        sendError("Archivo UserModel.php no encontrado en: $userModelPath");
    }
    
    // Capturar cualquier output durante el require
    ob_start();
    require_once $userModelPath;
    $userModelOutput = ob_get_clean();
    if (!empty($userModelOutput)) {
        file_put_contents($logFile, "Output durante carga de UserModel: $userModelOutput\n", FILE_APPEND);
    }
    
    file_put_contents($logFile, "✓ UserModel cargado\n", FILE_APPEND);
    
    // AuthController
    $authControllerPath = $baseDir . '/controllers/AuthController.php';
    if (!file_exists($authControllerPath)) {
        sendError("Archivo AuthController.php no encontrado en: $authControllerPath");
    }
    
    ob_start();
    require_once $authControllerPath;
    $authControllerOutput = ob_get_clean();
    if (!empty($authControllerOutput)) {
        file_put_contents($logFile, "Output durante carga de AuthController: $authControllerOutput\n", FILE_APPEND);
    }
    
    file_put_contents($logFile, "✓ AuthController cargado\n", FILE_APPEND);
    
    // 9. Verificar que la clase existe
    if (!class_exists('AuthController')) {
        sendError('Clase AuthController no encontrada después de cargar el archivo');
    }
    
    // 10. Crear instancia
    ob_start();
    $auth = new AuthController();
    $authOutput = ob_get_clean();
    if (!empty($authOutput)) {
        file_put_contents($logFile, "Output durante instanciación: $authOutput\n", FILE_APPEND);
    }
    
    if (!$auth) {
        sendError('No se pudo crear instancia de AuthController');
    }
    
    file_put_contents($logFile, "✓ AuthController instanciado\n", FILE_APPEND);
    
    // 11. Procesar acción
    switch ($action) {
        case 'register':
            file_put_contents($logFile, "Procesando REGISTER\n", FILE_APPEND);
            
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';
            
            if (empty($nombre) || empty($email) || empty($password)) {
                sendError('Todos los campos son obligatorios');
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                sendError('Email no válido');
            }
            
            if ($password !== $confirmPassword) {
                sendError('Las contraseñas no coinciden');
            }
            
            if (strlen($password) < 6) {
                sendError('La contraseña debe tener al menos 6 caracteres');
            }
            
            ob_start();
            $result = $auth->register([
                'nombre' => $nombre,
                'email' => $email,
                'password' => $password,
                'confirmPassword' => $confirmPassword
            ]);
            $registerOutput = ob_get_clean();
            
            if (!empty($registerOutput)) {
                file_put_contents($logFile, "Output durante register: $registerOutput\n", FILE_APPEND);
            }
            
            if (is_array($result) && isset($result['success'])) {
                if ($result['success']) {
                    sendSuccess($result['message'] ?? 'Registro exitoso');
                } else {
                    sendError($result['message'] ?? 'Error en registro');
                }
            } else {
                sendError('Respuesta inválida del método register');
            }
            break;
            
        case 'login':
            file_put_contents($logFile, "Procesando LOGIN\n", FILE_APPEND);
            
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            file_put_contents($logFile, "Login - Email: $email, Pass length: " . strlen($password) . "\n", FILE_APPEND);
            
            if (empty($email) || empty($password)) {
                sendError('Email y contraseña son obligatorios');
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                sendError('Email no válido');
            }
            
            ob_start();
            $result = $auth->login($email, $password);
            $loginOutput = ob_get_clean();
            
            if (!empty($loginOutput)) {
                file_put_contents($logFile, "Output durante login: $loginOutput\n", FILE_APPEND);
            }
            
            if (is_array($result) && isset($result['success'])) {
                if ($result['success']) {
                    $response = [
                        'success' => true,
                        'message' => $result['message'] ?? 'Login exitoso',
                        'user' => $result['user'] ?? null
                    ];
                    file_put_contents($logFile, "Login exitoso: " . json_encode($response) . "\n", FILE_APPEND);
                    echo json_encode($response);
                    exit;
                } else {
                    sendError($result['message'] ?? 'Error en login');
                }
            } else {
                sendError('Respuesta inválida del método login');
            }
            break;
            
        default:
            sendError('Acción no válida: ' . $action);
    }
    
} catch (Throwable $e) {
    // Captura cualquier error (Exception o Error)
    $errorMessage = "Error: " . $e->getMessage() . " en " . $e->getFile() . ":" . $e->getLine();
    file_put_contents($logFile, "EXCEPCIÓN: $errorMessage\n", FILE_APPEND);
    
    // Enviar respuesta de error segura
    $response = [
        'success' => false,
        'message' => 'Error interno del servidor',
        'debug' => 'Consulta el log para detalles'
    ];
    
    echo json_encode($response);
    exit;
}

// 12. Cierre
file_put_contents($logFile, "=== FIN ===\n\n", FILE_APPEND);