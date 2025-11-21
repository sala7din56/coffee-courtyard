document.addEventListener('DOMContentLoaded', () => {
    const menuItemsContainer = document.getElementById('menu-items');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');
    const orderForm = document.getElementById('order-form');
    const orderStatusContainer = document.getElementById('order-status');
    const mobileCartToggle = document.getElementById('mobile-cart-toggle');
    const mobileCartCount = document.getElementById('mobile-cart-count');
    const cartPanel = document.getElementById('cart-panel');
    const closeCart = document.getElementById('close-cart');

    let menu = [];
    let cart = [];

    // Mobile cart toggle
    if (mobileCartToggle) {
        mobileCartToggle.addEventListener('click', () => {
            cartPanel.classList.remove('hidden');
        });
    }

    if (closeCart) {
        closeCart.addEventListener('click', () => {
            cartPanel.classList.add('hidden');
        });
    }

    // Close cart when clicking outside
    if (cartPanel) {
        cartPanel.addEventListener('click', (e) => {
            if (e.target === cartPanel) {
                cartPanel.classList.add('hidden');
            }
        });
    }

    // Fetch menu items from the API
    fetch('api/menu.php')
        .then(response => response.json())
        .then(data => {
            menu = data;
            renderMenu();
        })
        .catch(error => {
            menuItemsContainer.innerHTML = '<p class="col-span-full text-center text-red-500">Error loading menu. Please try again later.</p>';
            console.error('Error fetching menu:', error);
        });

    // Render menu items
    function renderMenu() {
        menuItemsContainer.innerHTML = '';
        menu.forEach(item => {
            const menuItemElement = document.createElement('div');
            menuItemElement.className = 'flex flex-col gap-3 rounded-xl border border-primary/20 bg-white p-4 dark:bg-white/5 transition-shadow hover:shadow-md';

            const imageHtml = item.image_path
                ? `<img src="images/uploads/${item.image_path}" alt="${item.name}" class="w-full h-40 object-cover rounded-lg">`
                : `<div class="w-full h-40 bg-primary/10 rounded-lg flex items-center justify-center"><span class="material-symbols-outlined text-4xl text-primary/30">coffee</span></div>`;

            menuItemElement.innerHTML = `
                ${imageHtml}
                <div class="flex justify-between items-start">
                    <h4 class="text-base font-bold text-text-primary-light dark:text-text-primary-dark">${item.name}</h4>
                    <span class="text-base font-bold text-primary">$${parseFloat(item.price).toFixed(2)}</span>
                </div>
                <p class="text-xs text-text-secondary-light dark:text-text-secondary-dark line-clamp-2">${item.description}</p>
                <button data-id="${item.id}" class="add-to-cart-btn mt-auto w-full bg-primary hover:opacity-90 text-white font-bold py-2 px-4 rounded-lg transition-opacity duration-200 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                    Add to Cart
                </button>
            `;
            menuItemsContainer.appendChild(menuItemElement);
        });
    }

    // Add to cart
    menuItemsContainer.addEventListener('click', e => {
        if (e.target.classList.contains('add-to-cart-btn') || e.target.closest('.add-to-cart-btn')) {
            const btn = e.target.classList.contains('add-to-cart-btn') ? e.target : e.target.closest('.add-to-cart-btn');
            const itemId = btn.dataset.id;
            addToCart(itemId, 1);
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
        updateMobileCartCount();
    }

    function updateMobileCartCount() {
        const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        if (mobileCartCount) {
            mobileCartCount.textContent = totalItems;
        }
    }

    // Render cart
    function renderCart() {
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="text-center py-4">
                    <span class="material-symbols-outlined text-4xl text-primary/30">shopping_bag</span>
                    <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark mt-2">Your cart is empty</p>
                </div>
            `;
            cartTotalElement.textContent = '$0.00';
            return;
        }

        cartItemsContainer.innerHTML = '';
        let total = 0;
        cart.forEach((item, index) => {
            const cartItemElement = document.createElement('div');
            cartItemElement.className = 'bg-primary/5 rounded-lg p-3';
            cartItemElement.innerHTML = `
                <div class="flex justify-between items-start mb-2">
                    <p class="font-bold text-sm text-text-primary-light dark:text-text-primary-dark">${item.name}</p>
                    <button data-index="${index}" class="remove-from-cart-btn text-red-500 hover:text-red-700 text-lg leading-none">&times;</button>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <button data-index="${index}" class="decrease-qty-btn w-7 h-7 rounded-full bg-primary/20 hover:bg-primary/30 text-text-primary-light flex items-center justify-center font-bold">-</button>
                        <span class="text-sm font-medium w-6 text-center">${item.qty}</span>
                        <button data-index="${index}" class="increase-qty-btn w-7 h-7 rounded-full bg-primary/20 hover:bg-primary/30 text-text-primary-light flex items-center justify-center font-bold">+</button>
                    </div>
                    <span class="font-bold text-sm text-primary">$${(item.price * item.qty).toFixed(2)}</span>
                </div>
            `;
            cartItemsContainer.appendChild(cartItemElement);
            total += item.price * item.qty;
        });

        cartTotalElement.textContent = `$${total.toFixed(2)}`;
    }

    // Cart item actions
    cartItemsContainer.addEventListener('click', e => {
        if (e.target.classList.contains('remove-from-cart-btn')) {
            const itemIndex = e.target.dataset.index;
            cart.splice(itemIndex, 1);
            renderCart();
            updateMobileCartCount();
        }

        if (e.target.classList.contains('increase-qty-btn')) {
            const itemIndex = e.target.dataset.index;
            cart[itemIndex].qty += 1;
            renderCart();
            updateMobileCartCount();
        }

        if (e.target.classList.contains('decrease-qty-btn')) {
            const itemIndex = e.target.dataset.index;
            if (cart[itemIndex].qty > 1) {
                cart[itemIndex].qty -= 1;
            } else {
                cart.splice(itemIndex, 1);
            }
            renderCart();
            updateMobileCartCount();
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
                updateMobileCartCount();
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
        const bgColor = type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
        orderStatusContainer.innerHTML = `<p class="p-3 rounded-lg text-sm ${bgColor}">${message}</p>`;
        setTimeout(() => {
            orderStatusContainer.innerHTML = '';
        }, 5000);
    }
});
