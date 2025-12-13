<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Skechers Plus</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50">
<header class="bg-white/80 backdrop-blur-md shadow-sm p-4 flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center gap-3">
        <img src="imagenes/logo.png" alt="Logo" class="h-12 w-auto">
    </div>
    <button id="menu-btn" class="md:hidden text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <!-- Navegación -->
    <nav id="menu" class="hidden md:flex flex-col md:flex-row gap-4 absolute md:static top-16 left-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 shadow-md md:shadow-none">
        <a href="index.php" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">Inicio</a>
        <a href="register.php" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">Registro</a>
    </nav>
</header>

<main class="flex items-center justify-center min-h-screen py-8">
    <!-- Card login -->
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-8 mx-4">
        <div class="text-center mb-6">
            <img src="imagenes/logo.png" alt="Logo" class="h-12 mx-auto mb-2">
            <h1 class="text-3xl font-bold text-gray-800">Iniciar Sesión</h1>
        </div>

        <form id="loginForm" class="space-y-5">
            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Correo Electrónico</label>
                <input type="email" id="email" name="email" required placeholder="usuario@correo.com"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="********"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
            </div>

            <!-- Recordarme -->
            <div class="flex items-center">
                <input type="checkbox" id="remember" class="mr-2 accent-blue-400">
                <label for="remember" class="text-gray-700">Recordarme</label>
            </div>

            <!-- Mensaje de error/success -->
            <div id="messageContainer" class="text-center"></div>

            <!-- Botón -->
            <button type="submit" 
                    id="submitBtn"
                    class="w-full bg-blue-400 hover:bg-blue-500 text-white font-bold py-3 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed">
                Entrar
            </button>

            <!-- Registro -->
            <p class="text-center text-gray-500 mt-2">
                ¿No tienes cuenta? <a href="register.php" class="text-blue-500 hover:underline">Regístrate aquí</a>
            </p>
        </form>
    </div>
</main>

<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const form = e.target;
    const submitBtn = document.getElementById('submitBtn');
    const messageContainer = document.getElementById('messageContainer');
    
    // Obtener valores
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    
    // Validación básica
    if (!email || !password) {
        messageContainer.innerHTML = '<p class="text-red-600 text-sm">Por favor completa todos los campos</p>';
        return;
    }
    
    // Cambiar estado del botón
    submitBtn.disabled = true;
    submitBtn.textContent = 'Verificando...';
    messageContainer.innerHTML = '<p class="text-blue-600 text-sm">Verificando credenciales...</p>';
    
    // Crear FormData
    const formData = new FormData();
    formData.append('action', 'login');
    formData.append('email', email);
    formData.append('password', password);
    
    try {
        // IMPORTANTE: Usar auth_api.php (archivo SEPARADO)
        const res = await fetch('auth_api.php', {
            method: 'POST',
            body: formData
        });
        
        console.log('Status:', res.status);
        
        const text = await res.text();
        console.log('Respuesta texto:', text);
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (parseError) {
            console.error('Error parseando JSON:', parseError);
            messageContainer.innerHTML = '<p class="text-red-600 text-sm">Error en la respuesta del servidor</p>';
            submitBtn.disabled = false;
            submitBtn.textContent = 'Entrar';
            return;
        }
        
        console.log('Respuesta JSON:', data);
        
        if (data.success) {
            messageContainer.innerHTML = '<p class="text-green-600 text-sm">¡Inicio de sesión exitoso!</p>';
            
            // Redirigir
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 1000);
            
        } else {
            messageContainer.innerHTML = `<p class="text-red-600 text-sm">${data.message || 'Usuario o contraseña incorrectos'}</p>`;
            submitBtn.disabled = false;
            submitBtn.textContent = 'Entrar';
        }
        
    } catch (error) {
        console.error('Error en login:', error);
        messageContainer.innerHTML = `<p class="text-red-600 text-sm">Error de conexión: ${error.message}</p>`;
        submitBtn.disabled = false;
        submitBtn.textContent = 'Entrar';
    }
});

// Menú móvil
const btn = document.getElementById('menu-btn');
const menu = document.getElementById('menu');
if (btn && menu) {
    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
}
</script>
</body>
</html>