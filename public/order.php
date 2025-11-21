<?php require_once '../includes/header.php'; ?>

<div class="text-center mb-8">
    <h1 class="text-3xl font-bold leading-tight tracking-tight text-text-accent-light dark:text-text-accent-dark">Order Online</h1>
    <p class="mt-2 text-base font-normal leading-normal text-text-primary-light dark:text-text-primary-dark">Select your items and place your order below.</p>
</div>

<!-- Mobile Cart Toggle Button -->
<div class="lg:hidden fixed bottom-4 right-4 z-50">
    <button id="mobile-cart-toggle" class="bg-primary text-white p-4 rounded-full shadow-lg flex items-center gap-2">
        <span class="material-symbols-outlined">shopping_cart</span>
        <span id="mobile-cart-count" class="bg-white text-primary text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
    </button>
</div>

<div class="flex flex-col lg:flex-row gap-6">
    <!-- Menu Items -->
    <div id="menu-items" class="flex-1 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        <!-- Menu items will be loaded here by JavaScript -->
        <div class="col-span-full flex justify-center py-8">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Cart and Order Form -->
    <div class="lg:w-96 flex-shrink-0">
        <div id="cart-panel" class="fixed inset-0 bg-black/50 z-40 hidden lg:relative lg:inset-auto lg:bg-transparent lg:block">
            <div class="absolute right-0 top-0 h-full w-full max-w-md bg-background-light dark:bg-background-dark p-6 overflow-y-auto lg:relative lg:max-w-none lg:h-auto lg:max-h-screen rounded-xl border border-primary/20 shadow-md lg:sticky lg:top-4">
                <!-- Close button for mobile -->
                <button id="close-cart" class="lg:hidden absolute top-4 right-4 text-text-primary-light dark:text-text-primary-dark">
                    <span class="material-symbols-outlined">close</span>
                </button>

                <h2 class="text-2xl font-bold text-text-primary-light dark:text-text-primary-dark mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">shopping_cart</span>
                    Your Order
                </h2>

                <!-- Cart Items -->
                <div id="cart-items" class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                    <div class="text-center py-3">
                        <span class="material-symbols-outlined text-3xl text-primary/30">shopping_bag</span>
                        <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark mt-1">Your cart is empty</p>
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t border-primary/20 pt-4 mb-5">
                    <div class="flex justify-between items-center font-bold text-lg text-text-primary-light dark:text-text-primary-dark">
                        <span>Total</span>
                        <span id="cart-total" class="text-primary">$0.00</span>
                    </div>
                </div>

                <!-- Order Form -->
                <form id="order-form" class="space-y-4">
                    <div>
                        <label for="customerName" class="block text-sm font-medium text-text-primary-light dark:text-text-secondary-dark mb-1.5">Full Name</label>
                        <input type="text" id="customerName" name="customerName" required placeholder="John Doe" class="block w-full px-4 py-2.5 bg-white dark:bg-background-dark border border-primary/20 dark:border-primary/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-text-primary-light dark:text-text-secondary-dark mb-1.5">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required placeholder="(555) 123-4567" class="block w-full px-4 py-2.5 bg-white dark:bg-background-dark border border-primary/20 dark:border-primary/30 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                    </div>
                    <button type="submit" class="w-full bg-primary hover:opacity-90 text-white font-bold py-3 px-4 rounded-lg transition-opacity duration-200 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">receipt_long</span>
                        Place Order
                    </button>
                </form>

                <!-- Order Status -->
                <div id="order-status" class="mt-4 text-center"></div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>

<script src="js/order.js"></script>
