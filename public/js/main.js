/**
 * Main JavaScript for Coffee CourtYard Website
 * Handles smooth scrolling, mobile menu, and form validation
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {

    // Smooth scrolling for anchor links
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
        });
    }

    // Form validation
    const forms = document.querySelectorAll('form[data-validate="true"]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });

    // Image preview for file inputs
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            previewImage(this);
        });
    });

    // Close alerts
    const closeAlertBtns = document.querySelectorAll('.alert .close-btn');
    closeAlertBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            this.parentElement.remove();
        });
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Menu tabs functionality
    const menuTabs = document.querySelectorAll('.menu-tab-button');
    const menuCategories = document.querySelectorAll('.menu-category-content');

    if (menuTabs.length > 0 && menuCategories.length > 0) {
        // Initially, hide all categories except the first one
        menuCategories.forEach((category, index) => {
            if (index !== 0) {
                category.style.display = 'none';
            }
        });

        menuTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const categoryToShow = this.dataset.category;

                // Update active tab styles
                menuTabs.forEach(t => {
                    t.classList.remove('bg-primary', 'text-white');
                    t.classList.add('text-text-secondary-light', 'dark:text-text-secondary-dark');
                });
                this.classList.add('bg-primary', 'text-white');
                this.classList.remove('text-text-secondary-light', 'dark:text-text-secondary-dark');

                // Show/hide menu categories
                menuCategories.forEach(categoryContent => {
                    if (categoryContent.id === `menu-category-${categoryToShow}`) {
                        categoryContent.style.display = 'grid';
                    } else {
                        categoryContent.style.display = 'none';
                    }
                });
            });
        });
    }
});

/**
 * Validate form fields
 * @param {HTMLFormElement} form
 * @return {boolean}
 */
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(field => {
        const value = field.value.trim();
        const errorDiv = field.nextElementSibling;

        // Remove previous error
        if (errorDiv && errorDiv.classList.contains('error-message')) {
            errorDiv.remove();
        }
        field.classList.remove('error');

        // Check if empty
        if (value === '') {
            isValid = false;
            showFieldError(field, 'This field is required');
        }

        // Validate email
        if (field.type === 'email' && value !== '') {
            if (!isValidEmail(value)) {
                isValid = false;
                showFieldError(field, 'Please enter a valid email address');
            }
        }

        // Validate number
        if (field.type === 'number' && value !== '') {
            const num = parseFloat(value);
            const min = field.getAttribute('min');
            const max = field.getAttribute('max');

            if (min && num < parseFloat(min)) {
                isValid = false;
                showFieldError(field, `Value must be at least ${min}`);
            }

            if (max && num > parseFloat(max)) {
                isValid = false;
                showFieldError(field, `Value must be at most ${max}`);
            }
        }
    });

    return isValid;
}

/**
 * Show field error
 * @param {HTMLElement} field
 * @param {string} message
 */
function showFieldError(field, message) {
    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    field.parentNode.insertBefore(errorDiv, field.nextSibling);
}

/**
 * Validate email format
 * @param {string} email
 * @return {boolean}
 */
function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

/**
 * Preview image before upload
 * @param {HTMLInputElement} input
 */
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            let preview = input.parentElement.querySelector('.image-preview');

            if (!preview) {
                preview = document.createElement('img');
                preview.className = 'image-preview';
                input.parentElement.appendChild(preview);
            }

            preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Show loading spinner on button
 * @param {HTMLButtonElement} button
 */
function showButtonLoading(button) {
    button.classList.add('btn-loading');
    button.disabled = true;
}

/**
 * Hide loading spinner on button
 * @param {HTMLButtonElement} button
 */
function hideButtonLoading(button) {
    button.classList.remove('btn-loading');
    button.disabled = false;
}

/**
 * Confirm delete action
 * @param {string} itemName
 * @return {boolean}
 */
function confirmDelete(itemName) {
    return confirm(`Are you sure you want to delete "${itemName}"? This action cannot be undone.`);
}

// Export functions for use in other scripts
window.CoffeeCourtyard = {
    validateForm,
    showFieldError,
    isValidEmail,
    previewImage,
    showButtonLoading,
    hideButtonLoading,
    confirmDelete
};
