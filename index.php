

<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Skechers Plus - Inicio</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body class="bg-gray-50 text-gray-900">

<header class="bg-white/80 backdrop-blur-md border-b border-gray-200 p-4 flex justify-between items-center sticky top-0 z-50 shadow-sm">
    <img src="imagenes/logo.png" alt="Logo" class="h-12 w-auto drop-shadow-md">
    <button id="menu-btn" class="md:hidden text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <nav id="menu" class="hidden md:flex flex-col md:flex-row gap-4 absolute md:static top-16 left-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 shadow-md md:shadow-none">
        <a href="login.php" class="px-4 py-2 rounded-lg hover:bg-blue-100 transition">Login</a>
        <a href="register.php" class="px-4 py-2 rounded-lg hover:bg-blue-100 transition">Registro</a>
        <a href="carrito.php" class="px-4 py-2 rounded-lg hover:bg-blue-100 transition">🛒 Carrito</a>
    </nav>
</header>

<section class="relative h-[50vh] md:h-[70vh] w-full overflow-hidden">
    <video class="absolute inset-0 w-full h-full object-cover" autoplay loop muted>
        <source src="imagenes/video.webm" type="video/webm">
    </video>
    <div class="absolute inset-0 bg-white/40"></div>
    <div class="relative z-10 h-full flex flex-col justify-center items-center text-center p-6">
        <h1 class="text-4xl md:text-6xl font-extrabold drop-shadow-md">Bienvenido a <span class="text-blue-500">Skechers Plus</span></h1>
        <p class="mt-4 text-lg md:text-2xl text-gray-700 max-w-2xl">Descubre los mejores modelos deportivos con estilo y comodidad premium.</p>
        <a href="#catalogo" class="mt-6 px-6 py-3 bg-blue-400 hover:bg-blue-500 rounded-xl text-lg text-white shadow-md transition">Ver catálogo</a>
    </div>
</section>

<section id="catalogo" class="py-12 bg-gray-50 text-gray-900">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-10 text-gray-800">Catálogo Completo</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
            <!-- Repite una tarjeta por producto; importante: data-id coincide con products[].id -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-blue-200 transition transform hover:scale-[1.04] overflow-hidden">
                <img src="imagenes/0a.PNG" class="h-32 w-full object-contain m-4" alt="Modelo Alpha">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">Modelo Alpha</h3>
                    <p class="text-gray-500 mb-3">$85</p>
                    <button class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition add-to-cart" data-id="1">Agregar al carrito</button>
                </div>
            </div>

            <!-- MODELO 2 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-blue-200 transition transform hover:scale-[1.04] overflow-hidden">
                <img src="imagenes/1.PNG" class="h-32 w-full object-contain m-4" alt="Runner X">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">Runner X</h3>
                    <p class="text-gray-500 mb-3">$95</p>
                    <button class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition add-to-cart" data-id="2">Agregar al carrito</button>
                </div>
            </div>

            <!-- MODELO 3 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-blue-200 transition transform hover:scale-[1.04] overflow-hidden">
                <img src="imagenes/12.png" class="h-32 w-full object-contain m-4" alt="AirFlex">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">AirFlex</h3>
                    <p class="text-gray-500 mb-3">$60</p>
                    <button class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition add-to-cart" data-id="3">Agregar al carrito</button>
                </div>
            </div>

            <!-- MODELO 4 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-blue-200 transition transform hover:scale-[1.04] overflow-hidden">
                <img src="imagenes/2.PNG" class="h-32 w-full object-contain m-4" alt="UltraBoost Lite">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">UltraBoost Lite</h3>
                    <p class="text-gray-500 mb-3">$120</p>
                    <button class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition add-to-cart" data-id="4">Agregar al carrito</button>
                </div>
            </div>

            <!-- MODELO 5 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-blue-200 transition transform hover:scale-[1.04] overflow-hidden">
                <img src="imagenes/3.PNG" class="h-32 w-full object-contain m-4" alt="Street Max">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">Street Max</h3>
                    <p class="text-gray-500 mb-3">$75</p>
                    <button class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition add-to-cart" data-id="5">Agregar al carrito</button>
                </div>
            </div>

            <!-- MODELO 6 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-blue-200 transition transform hover:scale-[1.04] overflow-hidden">
                <img src="imagenes/4.PNG" class="h-32 w-full object-contain m-4" alt="Urban Flow">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">Urban Flow</h3>
                    <p class="text-gray-500 mb-3">$90</p>
                    <button class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition add-to-cart" data-id="6">Agregar al carrito</button>
                </div>
            </div>

            <!-- MODELO 7 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-blue-200 transition transform hover:scale-[1.04] overflow-hidden">
                <img src="imagenes/5.PNG" class="h-32 w-full object-contain m-4" alt="Sky Runner">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">Sky Runner</h3>
                    <p class="text-gray-500 mb-3">$110</p>
                    <button class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition add-to-cart" data-id="7">Agregar al carrito</button>
                </div>
            </div>

            <!-- MODELO 8 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-blue-200 transition transform hover:scale-[1.04] overflow-hidden">
                <img src="imagenes/6.PNG" class="h-32 w-full object-contain m-4" alt="Comfort Step">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-semibold text-gray-800">Comfort Step</h3>
                    <p class="text-gray-500 mb-3">$70</p>
                    <button class="px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition add-to-cart" data-id="8">Agregar al carrito</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const btn = document.getElementById('menu-btn');
const menu = document.getElementById('menu');
btn?.addEventListener('click', () => menu.classList.toggle('hidden'));
</script>

<script src="js/app.js"></script>

</body>
</html>
