<?php
/**
 * Coffee CourtYard - Main Homepage
 * Single page website with dynamic content from database
 */

require_once '../includes/header.php';
?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<?php
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
            <!-- Hero Section -->
            <section class="w-full py-12 mb-12" id="hero">
                <div class="flex min-h-[500px] flex-col items-center justify-center gap-6 rounded-xl bg-cover bg-center bg-no-repeat p-4 text-center"
                     style='background-image: linear-gradient(rgba(40, 54, 24, 0.4) 0%, rgba(40, 54, 24, 0.6) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuCP7p5H1mmlEAMGioR3cSUTNeLKD0QIruwoxWWDR71E-e8aVFX4A3P2r-3D0RyE1QZj_31mmQgQbQeTu6cgkzkcCw5f2eQmMiVTvUWwEXwwm2LHCtFsPhJkyPa7bj0MwitWmz1hXRuntkA2xRtUa7LzjoY0VQ29Ksv2rND6urpcfjnw7SRqRgYaSuQDFDJ7mBXkfrE-IlA1xYGcWCJSbf1sHEd0PkkyvoL1VLVnhz1BP-bPMYM87e-JdLpLX-MRQpePYwvCy1-4mQU");'>
                    <div class="flex flex-col gap-4">
                        <h1 class="text-5xl font-bold leading-tight tracking-tight text-background-light md:text-7xl">
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
            <section class="w-full py-12 mb-12 text-center" id="story">
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
            <section class="w-full py-12 mb-12" id="features">
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
            <section class="w-full py-12 mb-12" id="gallery">
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
            <section class="w-full py-12 mb-12" id="menu">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold leading-tight tracking-tight text-text-accent-light dark:text-text-accent-dark">Our Menu</h2>
                </div>

                <?php if (!empty($menuByCategory)): ?>
                    <div class="mb-8 flex justify-center">
                        <div id="menu-tabs" class="flex flex-wrap gap-2 rounded-lg bg-background-light p-2 dark:bg-white/5">
                            <?php $first = true; ?>
                            <?php foreach (array_keys($menuByCategory) as $category): ?>
                                <button class="menu-tab-button
                                    <?= $first ? 'bg-primary text-white' : 'text-text-secondary-light dark:text-text-secondary-dark' ?>
                                    rounded-md px-4 py-2 text-sm font-bold transition-colors"
                                    data-category="<?= htmlspecialchars($category) ?>">
                                    <?= htmlspecialchars($category) ?>
                                </button>
                                <?php $first = false; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php foreach ($menuByCategory as $category => $items): ?>
                        <div id="menu-category-<?= htmlspecialchars($category) ?>" class="menu-category-content grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            <?php foreach ($items as $item): ?>
                                <div class="menu-item-card flex flex-col gap-4 rounded-xl border border-primary/20 bg-white p-4 transition-shadow duration-300 hover:shadow-lg dark:border-primary/30 dark:bg-white/5 dark:hover:shadow-primary/10">
                                    <div class="relative h-48 w-full overflow-hidden rounded-lg">
                                        <?php if (!empty($item['image_path'])): ?>
                                            <img src="images/uploads/<?= htmlspecialchars($item['image_path']) ?>"
                                                 alt="<?= htmlspecialchars($item['name']) ?>"
                                                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"/>
                                        <?php else: ?>
                                            <div class="flex h-full w-full items-center justify-center rounded-lg bg-background-light dark:bg-white/10">
                                                <span class="material-symbols-outlined text-4xl text-text-secondary-light dark:text-text-secondary-dark">coffee</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex flex-1 flex-col justify-between gap-3">
                                        <div class="flex items-start justify-between gap-4">
                                            <h4 class="text-lg font-bold text-text-primary-light dark:text-text-primary-dark"><?= htmlspecialchars($item['name']) ?></h4>
                                            <span class="whitespace-nowrap rounded-full bg-primary/10 px-3 py-1 text-sm font-bold text-primary dark:bg-primary/20"><?= formatPrice($item['price']) ?></span>
                                        </div>
                                        <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark"><?= htmlspecialchars($item['description']) ?></p>
                                    </div>
                                    <button class="add-to-cart-button mt-auto flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-bold text-white transition-opacity hover:opacity-90">
                                        <span class="material-symbols-outlined">add_shopping_cart</span>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-text-secondary-light dark:text-text-secondary-dark">Menu items will be displayed here once added by admin.</p>
                <?php endif; ?>
            </section>

            <!-- Visit Us Section -->
            <section class="w-full py-12 mb-12" id="visit">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold leading-tight tracking-tight text-text-accent-light dark:text-text-accent-dark">Visit Us</h2>
                </div>
                <div class="grid grid-cols-1 gap-8 overflow-hidden rounded-xl border border-primary/30 shadow-xl bg-background-light dark:bg-background-dark md:grid-cols-2">
                    <div class="p-8 bg-background-light dark:bg-background-dark">
                        <h3 class="text-lg font-bold text-text-primary-light dark:text-text-primary-dark flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">location_on</span>Address
                        </h3>
                        <p class="mt-2 text-text-secondary-light dark:text-text-secondary-dark">
                            <?= htmlspecialchars($content['contact_address']['content_text'] ?? '123 Cafe Lane, Roastville, CA 90210') ?>
                        </p>

                        <h3 class="mt-6 text-lg font-bold text-text-primary-light dark:text-text-primary-dark flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">schedule</span>Hours
                        </h3>
                        <ul class="mt-2 space-y-1 text-text-secondary-light dark:text-text-secondary-dark">
                            <li>Mon-Fri: 6:00 AM - 6:00 PM</li>
                            <li>Sat: 7:00 AM - 5:00 PM</li>
                            <li>Sun: 7:00 AM - 3:00 PM</li>
                        </ul>

                        <h3 class="mt-6 text-lg font-bold text-text-primary-light dark:text-text-primary-dark flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">call</span>Contact
                        </h3>
                        <p class="mt-2 text-text-secondary-light dark:text-text-secondary-dark">
                            <?= htmlspecialchars($content['contact_email']['content_text'] ?? 'hello@coffeecourtyard.com') ?>
                        </p>
                        <?php if (isset($content['contact_phone'])): ?>
                            <p class="mt-1 text-text-secondary-light dark:text-text-secondary-dark">
                                <?= htmlspecialchars($content['contact_phone']['content_text']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="h-[400px] w-full rounded-xl overflow-hidden">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d205702.08756872435!2d43.70754806110078!3d36.1989178124126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x400722fe13443461%3A0x3e01d63391de79d1!2sErbil%2C%20Erbil%20Governorate!5e0!3m2!1sen!2siq!4v1763160598597!5m2!1sen!2siq"
                                class="h-full w-full"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </section>
    </div>

<?php require_once '../includes/footer.php'; ?>
