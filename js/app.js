// ============================
//  PRODUCTOS DISPONIBLES
// ============================
const products = [
    {id: "1", name: "Modelo Alpha", price: 85, img: "imagenes/0a.PNG"},
    {id: "2", name: "Runner X", price: 95, img: "imagenes/1.PNG"},
    {id: "3", name: "AirFlex", price: 60, img: "imagenes/12.png"},
    {id: "4", name: "UltraBoost Lite", price: 120, img: "imagenes/2.PNG"},
    {id: "5", name: "Street Max", price: 75, img: "imagenes/3.PNG"},
    {id: "6", name: "Urban Flow", price: 90, img: "imagenes/4.PNG"},
    {id: "7", name: "Sky Runner", price: 110, img: "imagenes/5.PNG"},
    {id: "8", name: "Comfort Step", price: 70, img: "imagenes/6.PNG"},
];

// ============================
//  LOCAL STORAGE CART
// ============================
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// ============================
//  MENSAJE (TOAST)
// ============================
function showMessage(text) {
    const msg = document.createElement("div");
    msg.textContent = text;
    msg.className =
        "fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded shadow-lg z-50";
    document.body.appendChild(msg);
    setTimeout(() => msg.remove(), 2000);
}

// ============================
//  INDEX: Agregar al carrito
// ============================
const addButtons = document.querySelectorAll(".add-to-cart");

if (addButtons.length > 0) {
    addButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const item = cart.find(p => p.id === id);

            if (item) {
                item.quantity += 1;
            } else {
                cart.push({ id, quantity: 1 });
            }

            saveCart();
            showMessage("Producto agregado al carrito!");
        });
    });
}

// ============================
//  FUNCION PARA CONFIRMAR COMPRA CON BACKEND
// ============================
async function confirmarCompraBackend() {
    if (cart.length === 0) return;

    try {
        const res = await fetch('/../controllers/PedidoController.php', {
            method: 'POST',
            body: JSON.stringify({ cart: cart }),
            headers: { 'Content-Type': 'application/json' }
        });
        const data = await res.json();

        if (data.success) {
            showMessage("Compra realizada con éxito");
            cart = [];
            saveCart();
            renderCart();
        } else {
            showMessage("Error al procesar la compra");
        }
    } catch (error) {
        console.error(error);
        showMessage("Error al conectar con el servidor");
    }
}

// ============================
//  CARRITO: Renderizado
// ============================
const cartItemsDiv = document.getElementById("cartItems");
const totalPriceSpan = document.getElementById("totalPrice");
const checkoutBtn = document.getElementById("checkoutBtn");

function renderCart() {
    if (!cartItemsDiv || !totalPriceSpan || !checkoutBtn) return;

    cartItemsDiv.innerHTML = "";

    if (cart.length === 0) {
        cartItemsDiv.innerHTML =
            "<p class='text-gray-600 col-span-full'>Tu carrito está vacío.</p>";
        totalPriceSpan.textContent = "0";
        checkoutBtn.disabled = true;
        checkoutBtn.classList.add("opacity-50", "cursor-not-allowed");
        return;
    }

    checkoutBtn.disabled = false;
    checkoutBtn.classList.remove("opacity-50", "cursor-not-allowed");

    let total = 0;

    cart.forEach(item => {
        const product = products.find(p => p.id === item.id);
        if (!product) return;

        const subtotal = product.price * item.quantity;
        total += subtotal;

        const itemDiv = document.createElement("div");
        itemDiv.className =
            "bg-white p-4 rounded-2xl shadow-lg flex flex-col items-center transition hover:shadow-blue-100";

        itemDiv.innerHTML = `
            <img src="${product.img}" class="h-40 object-contain mb-4" alt="${product.name}">
            <h3 class="text-xl font-semibold text-gray-800">${product.name}</h3>
            <p class="text-gray-500 mt-1">Precio: $${product.price}</p>

            <div class="flex items-center gap-2 mt-2">
                <label class="text-gray-700">Cantidad:</label>
                <input type="number" min="1" value="${item.quantity}"
                    class="w-16 p-1 border border-gray-300 rounded text-gray-800 quantity-input"
                    data-id="${item.id}">
            </div>

            <p class="text-gray-700 mt-1 font-medium">Subtotal: $${subtotal}</p>

            <button class="mt-2 bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-lg remove-item" data-id="${item.id}">
                Eliminar
            </button>
        `;

        cartItemsDiv.appendChild(itemDiv);
    });

    totalPriceSpan.textContent = total;
}

// ============================
//  CARRITO: Eventos
// ============================
if (cartItemsDiv) {
    // Actualizar cantidad
    cartItemsDiv.addEventListener("input", e => {
        if (e.target.classList.contains("quantity-input")) {
            const id = e.target.dataset.id;
            const value = parseInt(e.target.value) || 1;

            const item = cart.find(p => p.id === id);
            if (item) {
                item.quantity = value < 1 ? 1 : value;
                saveCart();
                renderCart();
            }
        }
    });

    // Eliminar item
    cartItemsDiv.addEventListener("click", e => {
        if (e.target.classList.contains("remove-item")) {
            const id = e.target.dataset.id;
            cart = cart.filter(p => p.id !== id);
            saveCart();
            renderCart();
        }
    });

    // Confirmar compra
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", () => confirmarCompraBackend());
    }

    // Render inicial
    renderCart();
}

document.getElementById('registerForm').addEventListener('submit', function(event) {
    // 1. Prevenir el envío tradicional del formulario
    event.preventDefault();

    const form = event.target;
    const messageContainer = document.getElementById('messageContainer');
    messageContainer.innerHTML = ''; // Limpiar mensajes anteriores

    // 2. Validar que las contraseñas coincidan (Validación del lado del cliente)
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        messageContainer.className = 'p-3 bg-red-100 text-red-700 rounded-lg';
        messageContainer.textContent = 'Las contraseñas no coinciden.';
        return; // Detener el envío
    }

    // 3. Crear el objeto FormData (incluye todos los campos, incluido el action oculto)
    const formData = new FormData(form);

    // 4. Enviar los datos con Fetch (AJAX)
    fetch(form.action, {
        method: form.method,
        body: formData
    })
    .then(response => response.json()) // El router PHP devuelve JSON
    .then(data => {
        // 5. Manejar la respuesta de PHP
        if (data.success) {
            // Éxito:
            messageContainer.className = 'p-3 bg-green-100 text-green-700 rounded-lg';
            messageContainer.textContent = data.message + '. Redirigiendo a login...';
            // Redirigir al usuario (ej. después de 2 segundos)
            setTimeout(() => {
                window.location.href = 'login.php'; 
            }, 2000);

        } else {
            // Error:
            messageContainer.className = 'p-3 bg-red-100 text-red-700 rounded-lg';
            messageContainer.textContent = 'Error: ' + data.message;
        }
    })
    .catch(error => {
        // Error de conexión o servidor
        console.error('Error de red:', error);
        messageContainer.className = 'p-3 bg-red-100 text-red-700 rounded-lg';
        messageContainer.textContent = 'Ocurrió un error de conexión con el servidor.';
    });
});