{
  "project": {
    "name": "Coffee CourtYard",
    "type": "single_page_website",
    "description": "A modern single-page website for a coffee shop with dynamic content controlled from an admin dashboard.",
    "design_reference": {
      "source_folder": "stitch_home_page",
      "description": "All layout, structure, and visuals must follow the design and mockups inside the 'stitch_home_page' folder created using Google Stitch."
    },
    "branding": {
      "primary_color": "#dda15e",
      "secondary_colors": ["#283618", "#fefae0", "#606c38", "#bc6c25"],
      "usage": "Apply the coffee-themed earthy palette consistently across the UI for buttons, backgrounds, accents, typography, and sections."
    },
    "frontend": {
      "technologies": ["HTML", "CSS"],
      "requirements": [
        "Recreate the UI exactly like the designs in 'stitch_home_page'.",
        "Use the given color palette and apply design consistency.",
        "Smooth scrolling navigation for sections.",
        "Responsive design for desktop, tablet, and mobile.",
        "Load menu items dynamically from the database.",
        "Include hero section, about section, menu section, gallery section, and contact section.",
        "Contact form must send data to backend."
      ]
    },
    "backend": {
      "language": "PHP",
      "framework": "Vanilla PHP",
      "server": "XAMPP (Apache)",
      "port": 8080,
      "features": [
        "Connect website to MySQL database.",
        "Display menu items and homepage content dynamically.",
        "Admin login/logout system with sessions.",
        "Admin dashboard to update website content.",
        "CRUD features for menu items: Create, Read, Update, Delete.",
        "CRUD for homepage sections such as hero title, about text, and images.",
        "Image upload support for menu items and homepage content.",
        "Input validation and SQL injection protection."
      ]
    },
    "database": {
      "engine": "MySQL",
      "host": "localhost",
      "port": 8080,
      "database_name": "coffee_courtyard_db",
      "tables": {
        "admin_users": {
          "fields": [
            "id INT AUTO_INCREMENT PRIMARY KEY",
            "username VARCHAR(255)",
            "password_hash VARCHAR(255)"
          ]
        },
        "menu_items": {
          "fields": [
            "id INT AUTO_INCREMENT PRIMARY KEY",
            "name VARCHAR(255)",
            "description TEXT",
            "price DECIMAL(10,2)",
            "image_path VARCHAR(255)",
            "category VARCHAR(255)"
          ]
        },
        "homepage_content": {
          "fields": [
            "id INT AUTO_INCREMENT PRIMARY KEY",
            "section_name VARCHAR(255)",
            "content_text LONGTEXT",
            "content_image VARCHAR(255)"
          ]
        }
      }
    },
    "admin_dashboard": {
      "purpose": "Provide full control over the website content.",
      "features": [
        "Admin authentication system.",
        "Dashboard overview with statistics.",
        "Manage homepage text and images.",
        "Manage menu items (CRUD).",
        "Upload and update images.",
        "Preview changes before publishing.",
        "Responsive dashboard layout."
      ],
      "ui": {
        "style": "simple_dark_theme",
        "technologies": ["HTML", "CSS", "PHP"],
        "components": [
          "Sidebar navigation",
          "Top navigation bar",
          "Editable forms",
          "Tables for listing menu items",
          "Image upload components"
        ]
      }
    },
    "output_requirements": [
      "Generate full folder structure.",
      "Provide all `.php`, `.html`, `.css`, and `.sql` files.",
      "Include database SQL export for easy import into phpMyAdmin.",
      "Explain how to configure XAMPP on port 8080.",
      "Document how to set up admin account and manage data.",
      "Use comments in code to explain important parts."
    ]
  }
}
