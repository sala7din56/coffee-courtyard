document.addEventListener('DOMContentLoaded', () => {
    const menuItemsContainer = document.getElementById('menu-items');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');
    const orderForm = document.getElementById('order-form');
    const orderStatusContainer = document.getElementById('order-status');

    let menu = [];
    let cart = [];

    // Fetch menu items from the API
    fetch('api/menu.php')
        .then(response => response.json())
        .then(data => {
            menu = data;
            renderMenu();
        })
        .catch(error => {
            menuItemsContainer.innerHTML = '<p class="text-red-500">Error loading menu. Please try again later.</p>';
            console.error('Error fetching menu:', error);
        });

    // Render menu items
    function renderMenu() {
        menuItemsContainer.innerHTML = '';
        menu.forEach(item => {
            const menuItemElement = document.createElement('div');
            menuItemElement.className = 'flex flex-col gap-3 rounded-xl border border-primary/20 bg-white p-5 dark:bg-white/5';
            menuItemElement.innerHTML = `
                <img src="images/uploads/${item.image_path}" alt="${item.name}" class="w-full h-48 object-cover rounded-lg mb-2">
                <div class="flex justify-between items-start">
                    <h4 class="text-lg font-bold text-text-primary-light dark:text-text-primary-dark">${item.name}</h4>
                    <span class="text-lg font-bold text-primary">$${parseFloat(item.price).toFixed(2)}</span>
                </div>
                <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">${item.description}</p>
                <div class="flex items-center gap-4 mt-auto">
                    <label for="qty-${item.id}" class="text-sm font-medium">Qty:</label>
                    <input type="number" id="qty-${item.id}" name="qty" min="1" value="1" class="w-16 rounded border-gray-300 dark:bg-background-dark dark:border-primary/30">
                    <button data-id="${item.id}" class="add-to-cart-btn ml-auto bg-primary hover:bg-accent text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">Add</button>
                </div>
            `;
            menuItemsContainer.appendChild(menuItemElement);
        });
    }

    // Add to cart
    menuItemsContainer.addEventListener('click', e => {
        if (e.target.classList.contains('add-to-cart-btn')) {
            const itemId = e.target.dataset.id;
            const qtyInput = document.getElementById(`qty-${itemId}`);
            const qty = parseInt(qtyInput.value);
            addToCart(itemId, qty);
        }
    });

    function addToCart(itemId, qty) {
        const menuItem = menu.find(item => item.id == itemId);
        if (!menuItem) return;

        const cartItem = cart.find(item => item.menuId == itemId);
        if (cartItem) {
            cartItem.qty += qty;
        } else {
            cart.push({ menuId: itemId, name: menuItem.name, price: menuItem.price, qty: qty });
        }
        renderCart();
    }

    // Render cart
    function renderCart() {
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="text-sm text-gray-500 dark:text-text-secondary-dark">Your cart is empty.</p>';
            cartTotalElement.textContent = '$0.00';
            return;
        }

        cartItemsContainer.innerHTML = '';
        let total = 0;
        cart.forEach((item, index) => {
            const cartItemElement = document.createElement('div');
            cartItemElement.className = 'flex justify-between items-center text-sm';
            cartItemElement.innerHTML = `
                <div>
                    <p class="font-bold text-text-primary-light dark:text-text-primary-dark">${item.name}</p>
                    <p class="text-text-secondary-light dark:text-text-secondary-dark">Qty: ${item.qty}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-text-primary-light dark:text-text-primary-dark">$${(item.price * item.qty).toFixed(2)}</span>
                    <button data-index="${index}" class="remove-from-cart-btn text-red-500 hover:text-red-700">&times;</button>
                </div>
            `;
            cartItemsContainer.appendChild(cartItemElement);
            total += item.price * item.qty;
        });

        cartTotalElement.textContent = `$${total.toFixed(2)}`;
    }
    
    // Remove from cart
    cartItemsContainer.addEventListener('click', e => {
        if (e.target.classList.contains('remove-from-cart-btn')) {
            const itemIndex = e.target.dataset.index;
            cart.splice(itemIndex, 1);
            renderCart();
        }
    });

    // Handle order submission
    orderForm.addEventListener('submit', e => {
        e.preventDefault();
        if (cart.length === 0) {
            showStatusMessage('Your cart is empty.', 'error');
            return;
        }

        const formData = new FormData(orderForm);
        const orderData = {
            customerName: formData.get('customerName'),
            phone: formData.get('phone'),
            items: cart.map(item => ({ menuId: item.menuId, qty: item.qty })),
        };

        fetch('api/orders.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.ok) {
                showStatusMessage(`Order placed successfully! Your order ID is ${data.orderId}.`, 'success');
                cart = [];
                renderCart();
                orderForm.reset();
            } else {
                showStatusMessage(data.error || 'Failed to place order.', 'error');
            }
        })
        .catch(error => {
            showStatusMessage('An error occurred. Please try again.', 'error');
            console.error('Error placing order:', error);
        });
    });

    function showStatusMessage(message, type) {
        orderStatusContainer.innerHTML = `<p class="${type === 'success' ? 'text-green-600' : 'text-red-600'}">${message}</p>`;
        setTimeout(() => {
            orderStatusContainer.innerHTML = '';
        }, 5000);
    }
});
