<?php require_once '../includes/header.php'; ?>

<div class="text-center">
    <h1 class="text-3xl font-bold leading-tight tracking-tight text-text-accent-light dark:text-text-accent-dark">Order Online</h1>
    <p class="mt-2 text-base font-normal leading-normal text-text-primary-light dark:text-text-primary-dark">Select your items and place your order below.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
    <!-- Menu Items -->
    <div id="menu-items" class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Menu items will be loaded here by JavaScript -->
        <p class="text-text-secondary-light dark:text-text-secondary-dark">Loading menu...</p>
    </div>

    <!-- Cart and Order Form -->
    <div class="md:col-span-1">
        <div class="sticky top-24 bg-white dark:bg-white/5 rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-secondary dark:text-text-primary-dark mb-4">Your Order</h2>
            
            <!-- Cart Items -->
            <div id="cart-items" class="space-y-4 mb-4">
                <p class="text-sm text-gray-500 dark:text-text-secondary-dark">Your cart is empty.</p>
            </div>

            <!-- Total -->
            <div class="border-t border-primary/20 pt-4 mb-6">
                <div class="flex justify-between items-center font-bold text-lg text-secondary dark:text-text-primary-dark">
                    <span>Total</span>
                    <span id="cart-total">$0.00</span>
                </div>
            </div>

            <!-- Order Form -->
            <form id="order-form" class="space-y-4">
                <div>
                    <label for="customerName" class="block text-sm font-medium text-secondary dark:text-text-secondary-dark">Full Name</label>
                    <input type="text" id="customerName" name="customerName" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-background-dark border border-gray-300 dark:border-primary/30 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-secondary dark:text-text-secondary-dark">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-background-dark border border-gray-300 dark:border-primary/30 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-accent text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200">
                    Place Order
                </button>
            </form>
            
            <!-- Order Status -->
            <div id="order-status" class="mt-4 text-center"></div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>

<script src="js/order.js"></script>
