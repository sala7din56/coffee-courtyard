<?php
/**
 * Coffee CourtYard - Main Homepage
 * Single page website with dynamic content from database
 */

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Initialize database connection
$db = new Database();

// Fetch homepage content
$content = getAllHomepageContent($db);

// Fetch menu items
$menuItems = getMenuItemsByCategory($db);

// Group menu items by category
$menuByCategory = [];
foreach ($menuItems as $item) {
    $menuByCategory[$item['category']][] = $item;
}
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Coffee CourtYard - Your Everyday Escape</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link href="css/styles.css" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#dda15e",
                        "background-light": "#fefae0",
                        "background-dark": "#201912",
                        "text-primary-light": "#283618",
                        "text-secondary-light": "#606c38",
                        "text-accent-light": "#bc6c25",
                        "text-primary-dark": "#fefae0",
                        "text-secondary-dark": "#a3b18a",
                        "text-accent-dark": "#dda15e"
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="relative flex min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 flex items-center justify-center border-b border-solid border-primary/20 bg-background-light/80 px-4 py-3 backdrop-blur-sm dark:bg-background-dark/80 dark:border-primary/20">
        <div class="flex w-full max-w-6xl items-center justify-between whitespace-nowrap">
            <div class="flex items-center gap-3 text-text-primary-light dark:text-text-primary-dark">
                <span class="material-symbols-outlined text-primary text-2xl">local_cafe</span>
                <h2 class="text-lg font-bold tracking-tight">Coffee CourtYard</h2>
            </div>
            <div class="hidden items-center gap-8 md:flex">
                <a class="text-sm font-medium text-text-primary-light transition-colors hover:text-text-accent-light dark:text-text-primary-dark dark:hover:text-text-accent-dark" href="#story">Our Story</a>
                <a class="text-sm font-medium text-text-primary-light transition-colors hover:text-text-accent-light dark:text-text-primary-dark dark:hover:text-text-accent-dark" href="#menu">Menu</a>
                <a class="text-sm font-medium text-text-primary-light transition-colors hover:text-text-accent-light dark:text-text-primary-dark dark:hover:text-text-accent-dark" href="#visit">Visit Us</a>
            </div>
            <button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-text-primary-light text-sm font-bold tracking-wide transition-opacity hover:opacity-90">
                <span class="truncate">Order Online</span>
            </button>
        </div>
    </header>

    <main class="flex flex-1 justify-center py-5">
        <div class="flex w-full max-w-6xl flex-col gap-12 px-4">

            <!-- Hero Section -->
            <section class="w-full" id="hero">
                <div class="flex min-h-[500px] flex-col items-center justify-center gap-6 rounded-xl bg-cover bg-center bg-no-repeat p-4 text-center"
                     style='background-image: linear-gradient(rgba(40, 54, 24, 0.4) 0%, rgba(40, 54, 24, 0.6) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuCP7p5H1mmlEAMGioR3cSUTNeLKD0QIruwoxWWDR71E-e8aVFX4A3P2r-3D0RyE1QZj_31mmQgQbQeTu6cgkzkcCw5f2eQmMiVTvUWwEXwwm2LHCtFsPhJkyPa7bj0MwitWmz1hXRuntkA2xRtUa7LzjoY0VQ29Ksv2rND6urpcfjnw7SRqRgYaSuQDFDJ7mBXkfrE-IlA1xYGcWCJSbf1sHEd0PkkyvoL1VLVnhz1BP-bPMYM87e-JdLpLX-MRQpePYwvCy1-4mQU");'>
                    <div class="flex flex-col gap-4">
                        <h1 class="text-4xl font-black leading-tight tracking-tight text-background-light md:text-6xl">
                            <?= htmlspecialchars($content['hero_title']['content_text'] ?? 'Your Everyday Escape.') ?>
                        </h1>
                        <h2 class="text-base font-normal leading-normal text-background-light/90 md:text-lg">
                            <?= htmlspecialchars($content['hero_subtitle']['content_text'] ?? 'Artisan coffee, fresh pastries, and a quiet courtyard to unwind.') ?>
                        </h2>
                    </div>
                    <a class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-text-primary-light text-base font-bold tracking-wide transition-opacity hover:opacity-90" href="#menu">
                        <span class="truncate">View Our Menu</span>
                    </a>
                </div>
            </section>

            <!-- About Section -->
            <section class="w-full text-center" id="story">
                <h2 class="text-3xl font-bold leading-tight tracking-tight text-text-accent-light dark:text-text-accent-dark">
                    <?= htmlspecialchars($content['about_title']['content_text'] ?? 'Our Story') ?>
                </h2>
                <div class="mx-auto mt-4 max-w-3xl">
                    <p class="text-base font-normal leading-relaxed text-text-primary-light dark:text-text-primary-dark">
                        <?= htmlspecialchars($content['about_text']['content_text'] ?? 'Coffee CourtYard was born from a simple idea: to create a warm and inviting space where the community can gather, relax, and enjoy exceptionally crafted coffee.') ?>
                    </p>
                </div>
            </section>

            <!-- Features Section -->
            <section class="w-full" id="features">
                <div class="flex flex-col gap-10">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold leading-tight tracking-tight text-text-accent-light dark:text-text-accent-dark">What Makes Us Special</h2>
                        <p class="mt-2 text-base font-normal leading-normal text-text-primary-light dark:text-text-primary-dark">We believe in quality and comfort, from our beans to our seating.</p>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="flex flex-1 flex-col gap-3 rounded-xl border border-primary/20 bg-background-light p-4 dark:bg-white/5 dark:border-primary/30">
                            <span class="material-symbols-outlined text-3xl text-primary">coffee</span>
                            <div class="flex flex-col gap-1">
                                <h3 class="text-base font-bold leading-tight text-text-primary-light dark:text-text-primary-dark">Artisanal Roasts</h3>
                                <p class="text-sm font-normal leading-normal text-text-secondary-light dark:text-text-secondary-dark">Sourced from the best growers and roasted to perfection for a rich, flavorful cup.</p>
                            </div>
                        </div>
                        <div class="flex flex-1 flex-col gap-3 rounded-xl border border-primary/20 bg-background-light p-4 dark:bg-white/5 dark:border-primary/30">
                            <span class="material-symbols-outlined text-3xl text-primary">bakery_dining</span>
                            <div class="flex flex-col gap-1">
                                <h3 class="text-base font-bold leading-tight text-text-primary-light dark:text-text-primary-dark">Homemade Pastries</h3>
                                <p class="text-sm font-normal leading-normal text-text-secondary-light dark:text-text-secondary-dark">Freshly baked every morning by local artisans to pair perfectly with your coffee.</p>
                            </div>
                        </div>
                        <div class="flex flex-1 flex-col gap-3 rounded-xl border border-primary/20 bg-background-light p-4 dark:bg-white/5 dark:border-primary/30">
                            <span class="material-symbols-outlined text-3xl text-primary">pets</span>
                            <div class="flex flex-col gap-1">
                                <h3 class="text-base font-bold leading-tight text-text-primary-light dark:text-text-primary-dark">Pet-Friendly Courtyard</h3>
                                <p class="text-sm font-normal leading-normal text-text-secondary-light dark:text-text-secondary-dark">Our sun-drenched, pet-friendly courtyard is your perfect urban oasis.</p>
                            </div>
                        </div>
                        <div class="flex flex-1 flex-col gap-3 rounded-xl border border-primary/20 bg-background-light p-4 dark:bg-white/5 dark:border-primary/30">
                            <span class="material-symbols-outlined text-3xl text-primary">wifi</span>
                            <div class="flex flex-col gap-1">
                                <h3 class="text-base font-bold leading-tight text-text-primary-light dark:text-text-primary-dark">Free Wi-Fi</h3>
                                <p class="text-sm font-normal leading-normal text-text-secondary-light dark:text-text-secondary-dark">Stay connected while you relax with our complimentary high-speed internet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Gallery Section -->
            <section class="w-full" id="gallery">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold leading-tight tracking-tight text-text-accent-light dark:text-text-accent-dark">A Glimpse Inside</h2>
                </div>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    <div class="grid gap-4">
                        <div><img class="h-auto max-w-full rounded-lg object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA1ZGuydmr7RvvtrAWQWF1H9c6WcTwvR1PwLRPfzSaMOzT_qrJm3g5AwAfoIMSnYXcRwHdZsrqWsRAXiJyIdY7KJtrclHsyaj3W6ccEhMoQ0p9rVB88-0Ed24et2D_DsCiWVBBnpMMt7_thUniWl0VvbZZ_V093bif8JMGy_2AzR2NdYwGzColfD6FHDL5fIqRhiZo_L5F8T4mz6DOOMhUfA8NkdYMbzTQH8G5rUvInEoc_l0MihUrdKDytDwKIqCMzQpWu-r6-m9E" alt="Barista making latte art"/></div>
                        <div><img class="h-auto max-w-full rounded-lg object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCKnh-mYHHpVLEab-R0R1EpxTp36I0R-xDbYghU4DTJNhBjm_gmiOuqGO06vKaTb0YCDFZ80L70ydbUp1UXVIXti4uhiusPehDR1kVLeeZoZ_g7VE1VGwrGnTTchF6xZBWN_YzIeeUavQQWKnW3ERu_NRdsDdidEweMFpnoOGVmceXwbL4j41twwBAKYaVEnq9edNrvw4zn-XPyCKnCTV0PixXMxNa0SBMpbDNePXTev09jT2GqFZlDqwolaIOnQkrzlRPrioFZMNQ" alt="Coffee cup with beans"/></div>
                    </div>
                    <div class="grid gap-4">
                        <div><img class="h-auto max-w-full rounded-lg object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPjZA8X7RM6OS4KtRilF2oesfnuvvvh2GGDagnMg3J9FOpOLgy7BalpPNdfn5lWZCbk-0iKZgdXJV76ZNcuRxkj22oCMYHdlhxgP5ZjUF8W6S_NVwCWPCufftOdU40ovkuQY4w4lOiQKPHCYX0GTaMJIPl9WFqcHzM25Tsn3ck7WTxIwPiHnrKzTfr1ELQ7eW5nqmD-v94ae1r8xU71SD3VQU4l8NGbk10AAvk3-4wHMV8MfgYOufPhd-bfzYPVqa1J08aeOQu_KM" alt="Fresh pastries"/></div>
                        <div><img class="h-auto max-w-full rounded-lg object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAt_hCwhN94y7J01-J3mKdLoAyCKnKotJORF2GitiTXPlNyJkAXyIdGp-ySJnGvnE6bxZDi9HZiDD0uQvQcAXyJRNZyxXqQoMaXcxRvYVNaMd53Ivx0ryvNSGJFsVNZlWUUhbK1HLC2izJUoku_mkboic8ih1WVZKKiaw8xdVb3bpYuTDManNj3pHIK636e3932eE-fO0at5iiUS6ql5r22beD3KIcqBXkYgTiVYDY4x0uLWKh-kycAGkZ8ycmBPNfnHgZdgtv2weg" alt="Hands holding coffee"/></div>
                    </div>
                    <div class="grid gap-4">
                        <div><img class="h-auto max-w-full rounded-lg object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB_tJnNsgrNqVQPwTdOSzseL_M-5pY2mW9LFtEkefiN6FQE1IwtAEbmYcEMCPdXG8n8-QxqquvX7ayBVzldhDbKep-pxX9rZil_KpAS--FTLL0oE5J7SOFrjbcYdhtZXKphd13W2w_CJj--ZUMdtYFwrxifnaKER1TqJHo0BHl0eUbsrCddxN9XyIwRzXDJyJKHOn3xx334MVqJHs-3SRjeZs688qdMsfB4zs3ZhynJmU_KRvUoXCNXwPpk8u8aoDev0FvRpa-1Hdk" alt="Cafe interior"/></div>
                        <div><img class="h-auto max-w-full rounded-lg object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAKcgp37Bmkb0UAhqYDhH93z9N2nzykWm87Q-LFifU_yEacVEtsJ8OEanA8QfRomrVCmjufc4Vq_iCLYAKv9l-PyfhpPR3jWTdhDsvC0wBY8BrDzu16DSBoTOlGBQKuYLQXb5Bd9U9XhCOdMm82olSmP_HFwO9ATVHXuMebZ66ttuMP5LSXvo9BWvy_LJE8mq02mXIZkZfDd5SgXnCSNBjLPJTTztKKEHhO8PT0goTGw0Oenh8Inl9xMACzcJTeG5IKOwGbKW1pFdY" alt="Croissant and coffee"/></div>
                    </div>
                    <div class="grid gap-4">
                        <div><img class="h-auto max-w-full rounded-lg object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3ZJWbtecBbbKN1EGMl_qrvDj-xtQaufQB9bAEVCqG7LoVY4JAzmUH0zh7666P8cPLaW0zVxV7RGP23t9SZqPYDVpXRlp1-7BxyfRnZ65sodlj7y6Kj_oKQv0zejkw-FSKLvOO5zDo_9dj7HVAFEprfT0masUhwEXwe9LpZr1m4ujdwlL7DOCgLZoWUPu-cEfE23dYgxvdMvQwh4o_jyxKa0DZLJqXrMfcmJahrU9R8qwAp9Q01i_yBdu-pRXOSTfpQbSjEObA6Gk" alt="Outdoor courtyard"/></div>
                        <div><img class="h-auto max-w-full rounded-lg object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA-Ohwh-KBdD1AFp-dZvM5VqROw10xHiVZKLVIkEOunkOmH_5VnkX3ooqKYtLjKUjpfqdcQmmkaJqcv4F3Kb4o487OXjnWYBKIKsyxtAXJOZf9K9jyCeFCP5G7GPN9cKlmHFXWy7Y_j1d0HJ5A_vGN03guyrhktThURiWQhV2sIIW7ujWp7pbWRiziAm5aFJVykMue2x_ZeHZEp34mUV22rZx5UClJH0-Q_XySoXDbx7yg29g5WmI3C2a2zhpiLW7pnGgPD6XX9j_k" alt="Barista smiling"/></div>
                    </div>
                </div>
            </section>

            <!-- Menu Section -->
            <section class="w-full" id="menu">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold leading-tight tracking-tight text-text-accent-light dark:text-text-accent-dark">Our Menu</h2>
                </div>

                <?php if (!empty($menuByCategory)): ?>
                    <?php foreach ($menuByCategory as $category => $items): ?>
                        <div class="mb-12">
                            <h3 class="text-2xl font-bold text-text-secondary-light dark:text-text-secondary-dark mb-6"><?= htmlspecialchars($category) ?></h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                                <?php foreach ($items as $item): ?>
                                    <div class="flex flex-col gap-3 rounded-xl border border-primary/20 bg-white p-5 dark:bg-white/5">
                                        <?php if (!empty($item['image_path'])): ?>
                                            <img src="images/uploads/<?= htmlspecialchars($item['image_path']) ?>"
                                                 alt="<?= htmlspecialchars($item['name']) ?>"
                                                 class="w-full h-48 object-cover rounded-lg mb-2"/>
                                        <?php endif; ?>
                                        <div class="flex justify-between items-start">
                                            <h4 class="text-lg font-bold text-text-primary-light dark:text-text-primary-dark"><?= htmlspecialchars($item['name']) ?></h4>
                                            <span class="text-lg font-bold text-primary"><?= formatPrice($item['price']) ?></span>
                                        </div>
                                        <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark"><?= htmlspecialchars($item['description']) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-text-secondary-light dark:text-text-secondary-dark">Menu items will be displayed here once added by admin.</p>
                <?php endif; ?>
            </section>

            <!-- Visit Us Section -->
            <section class="w-full" id="visit">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold leading-tight tracking-tight text-text-accent-light dark:text-text-accent-dark">Visit Us</h2>
                </div>
                <div class="grid grid-cols-1 gap-8 overflow-hidden rounded-xl border border-primary/20 md:grid-cols-2">
                    <div class="bg-primary/10 p-8 dark:bg-white/5">
                        <h3 class="text-lg font-bold text-text-primary-light dark:text-text-primary-dark">Address</h3>
                        <p class="mt-2 text-text-secondary-light dark:text-text-secondary-dark">
                            <?= htmlspecialchars($content['contact_address']['content_text'] ?? '123 Cafe Lane, Roastville, CA 90210') ?>
                        </p>

                        <h3 class="mt-6 text-lg font-bold text-text-primary-light dark:text-text-primary-dark">Hours</h3>
                        <ul class="mt-2 space-y-1 text-text-secondary-light dark:text-text-secondary-dark">
                            <li>Mon-Fri: 6:00 AM - 6:00 PM</li>
                            <li>Sat: 7:00 AM - 5:00 PM</li>
                            <li>Sun: 7:00 AM - 3:00 PM</li>
                        </ul>

                        <h3 class="mt-6 text-lg font-bold text-text-primary-light dark:text-text-primary-dark">Contact</h3>
                        <p class="mt-2 text-text-secondary-light dark:text-text-secondary-dark">
                            <?= htmlspecialchars($content['contact_email']['content_text'] ?? 'hello@coffeecourtyard.com') ?>
                        </p>
                        <?php if (isset($content['contact_phone'])): ?>
                            <p class="mt-1 text-text-secondary-light dark:text-text-secondary-dark">
                                <?= htmlspecialchars($content['contact_phone']['content_text']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="min-h-[300px] w-full">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3305.659933580554!2d-118.384463384781!3d34.07541698060408!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2b94a0d9b8e9d%3A0x5e4d2e0b1f1a5e1d!2sBeverly%20Hills%2C%20CA%2090210%2C%20USA!5e0!3m2!1sen!2suk!4v1675865239567!5m2!1sen!2suk"
                                width="100%"
                                height="100%"
                                style="border:0; min-height: 400px;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <footer class="flex justify-center border-t border-solid border-primary/20 bg-background-light px-4 py-8 dark:bg-background-dark dark:border-primary/20">
        <div class="flex w-full max-w-6xl flex-col items-center justify-between gap-4 text-center md:flex-row md:text-left">
            <div class="flex items-center gap-3 text-text-primary-light dark:text-text-primary-dark">
                <span class="material-symbols-outlined text-primary text-2xl">local_cafe</span>
                <h2 class="text-base font-bold tracking-tight">Coffee CourtYard</h2>
            </div>
            <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">© 2024 Coffee CourtYard. All Rights Reserved.</p>
            <div class="flex items-center gap-4">
                <a class="text-text-secondary-light transition-colors hover:text-primary dark:text-text-secondary-dark dark:hover:text-primary" href="#">
                    <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path clip-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" fill-rule="evenodd"></path>
                    </svg>
                </a>
                <a class="text-text-secondary-light transition-colors hover:text-primary dark:text-text-secondary-dark dark:hover:text-primary" href="#">
                    <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path clip-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.012-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.08 2.525c.636-.247 1.363-.416 2.427-.465C9.53 2.013 9.884 2 12.315 2zM12 7a5 5 0 100 10 5 5 0 000-10zm0-2a7 7 0 110 14 7 7 0 010-14zm6.406-1.185a1.285 1.285 0 00-1.816 1.816 1.285 1.285 0 001.816-1.816z" fill-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </footer>
</div>
</div>

<script src="js/main.js"></script>
</body>
</html>
