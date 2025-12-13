<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrito - Skechers Plus</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

<header class="bg-white/80 backdrop-blur-md shadow-sm p-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <img src="imagenes/logo.png" alt="Logo" class="h-12 w-auto">
    </div>
    <button id="menu-btn" class="md:hidden text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <nav id="menu" class="hidden md:flex flex-col md:flex-row gap-4 absolute md:static top-16 left-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 shadow-md md:shadow-none">
        <a href="index.php" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">Inicio</a>
        <a href="login.php" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">Login</a>
    </nav>
</header>

<main class="flex-grow max-w-6xl mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Tu Carrito</h2>

    <div id="cartItems" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6"></div>

    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row justify-between items-center">
        <div class="text-gray-800 text-xl font-semibold">Total: $<span id="totalPrice">0</span></div>
        <button id="checkoutBtn" class="mt-4 md:mt-0 bg-blue-400 hover:bg-blue-500 text-white font-bold px-6 py-3 rounded-lg transition opacity-50 cursor-not-allowed" disabled>Proceder a Comprar</button>
    </div>
</main>

<footer class="bg-white/80 backdrop-blur-md shadow-sm p-4 text-center text-gray-600">© 2025 Skechers Plus. Todos los derechos reservados.</footer>

<script>
const btn = document.getElementById('menu-btn');
const menu = document.getElementById('menu');
btn?.addEventListener('click', () => menu.classList.toggle('hidden'));
</script>

<script src="js/app.js"></script>
</body>
</html>
