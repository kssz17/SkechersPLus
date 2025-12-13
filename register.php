<?php include "config.php"; ?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Skechers Plus</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>


    <header class="bg-white/80 backdrop-blur-md shadow-sm p-4 flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center gap-3">
         <img src="imagenes/logo.png" alt="Logo" class="h-12 w-auto">
    </div>
  <button id="menu-btn" class="md:hidden text-gray-700 focus:outline-none">
        <!-- Icono hamburguesa -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <!-- Navegación -->
  <nav id="menu" class="hidden md:flex flex-col md:flex-row gap-4 absolute md:static top-16 left-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 shadow-md md:shadow-none">
        <a href="index.php" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">Inicio</a>
        <a href="login.php" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">login</a>
    </nav>
</header>
<main  class="bg-gray-50 flex items-center justify-center min-h-screen">


    <!-- Card registro -->
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-8">
        <div class="text-center mb-6">
            <img src="imagenes/logo.png" alt="Logo" class="h-12 mx-auto mb-2">
            <h1 class="text-3xl font-bold text-gray-800">Crear Cuenta</h1>
        </div>

<form action="auth_api.php" method="POST" id="registerForm" class="space-y-5"> 
    <input type="hidden" name="action" value="register">

    <div>
        <label for="name" class="block text-gray-700 font-medium mb-1">Nombre Completo</label>
        <input type="text" id="name" name="nombre" required placeholder="Tu nombre" 
        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
    </div>

    <div>
        <label for="email" class="block text-gray-700 font-medium mb-1">Correo Electrónico</label>
        <input type="email" id="email" name="email" required placeholder="usuario@correo.com"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
    </div>

    <div>
        <label for="password" class="block text-gray-700 font-medium mb-1">Contraseña</label>
        <input type="password" id="password" name="password" required placeholder="********"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
    </div>

    <div>
        <label for="confirmPassword" class="block text-gray-700 font-medium mb-1">Confirmar Contraseña</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="********"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition">
    </div>
    
    <div id="messageContainer" class="text-center font-bold"></div>

    <button type="submit" class="w-full bg-blue-400 hover:bg-blue-500 text-white font-bold py-3 rounded-lg transition">
        Registrarse
    </button>
    
    <p class="text-center text-gray-500 mt-2">
        ¿Ya tienes cuenta? <a href="login.php" class="text-blue-500 hover:underline">Inicia sesión aquí</a>
    </p>
</form>
    </div>
</main>
 <script>
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('action', 'register');

    try {
        const res = await fetch('auth_api.php', {  // Ajusta la ruta
            method: 'POST',
            body: formData
        });

        if (!res.ok) {
            throw new Error('Error en la respuesta del servidor: ' + res.status);
        }

        const data = await res.json();

        if (data.success) {
            alert('Registro exitoso, ahora inicia sesión');
            window.location.href = 'login.php';
        } else {
            alert('Error al registrar usuario: ' + (data.message || 'desconocido'));
        }
    } catch (err) {
        alert('Error al procesar la petición: ' + err.message);
        console.error(err);
    }
});
</script>
</body>
</html>
