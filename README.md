# Coffee CourtYard Website

A modern, dynamic single-page website for a coffee shop with a comprehensive admin dashboard for content management.

## Project Overview

Coffee CourtYard is a fully functional website built with:
- **Frontend**: HTML, CSS (TailwindCSS), Vanilla JavaScript
- **Backend**: PHP (Vanilla)
- **Database**: MySQL
- **Server**: XAMPP (Apache on port 8080)

## Features

### Public Website
- **Single Page Design**: Smooth scrolling navigation between sections
- **Dynamic Content**: Menu items and homepage content loaded from database
- **Responsive Layout**: Works perfectly on desktop, tablet, and mobile
- **Sections**:
  - Hero section with call-to-action
  - About section with company story
  - Features showcase
  - Image gallery
  - Dynamic menu display by category
  - Contact information with Google Maps
  - Social media links

### Admin Dashboard
- **Secure Login**: Session-based authentication
- **Dashboard Overview**: Statistics and quick actions
- **Menu Management**: Full CRUD operations for menu items
  - Add, edit, delete menu items
  - Upload and manage images
  - Organize by categories
  - Set prices and descriptions
- **Homepage Content**: Edit all homepage text sections
  - Hero title and subtitle
  - About section
  - Contact information
- **Image Upload**: Secure file handling with validation

## Installation Instructions

### Prerequisites
1. **XAMPP** installed on your computer
   - Download from: https://www.apachefriends.org/
   - Includes Apache, MySQL, and PHP

### Step 1: Extract Project Files

1. Extract the `coffee_courtyard` folder
2. Copy the entire `coffee_courtyard` folder to your XAMPP `htdocs` directory:
   - Windows: `C:\xampp\htdocs\`
   - Mac: `/Applications/XAMPP/htdocs/`
   - Linux: `/opt/lampp/htdocs/`

Your structure should be:
```
htdocs/
└── coffee_courtyard/
    ├── admin/
    ├── database/
    ├── includes/
    └── public/
```

### Step 2: Configure XAMPP to Run on Port 8080

1. **Open XAMPP Control Panel**

2. **Configure Apache Port**:
   - Click "Config" button next to Apache
   - Select "httpd.conf"
   - Find the line: `Listen 80`
   - Change it to: `Listen 8080`
   - Find the line: `ServerName localhost:80`
   - Change it to: `ServerName localhost:8080`
   - Save and close

3. **Configure Apache SSL Port** (optional):
   - Click "Config" button next to Apache
   - Select "httpd-ssl.conf"
   - Find: `Listen 443`
   - Change to: `Listen 4433`
   - Find: `<VirtualHost _default_:443>`
   - Change to: `<VirtualHost _default_:4433>`
   - Save and close

4. **Start Apache and MySQL** from XAMPP Control Panel

### Step 3: Create Database

1. **Open phpMyAdmin**:
   - Go to: `http://localhost:8080/phpmyadmin`

2. **Import Database**:
   - Click "New" in the left sidebar to create a new database
   - Enter database name: `coffee_courtyard_db`
   - Click "Create"
   - Select the newly created database
   - Click "Import" tab
   - Choose file: `coffee_courtyard/database/coffee_courtyard_db.sql`
   - Click "Go" to import

Alternatively, you can run the SQL file directly:
- Click "SQL" tab in phpMyAdmin
- Copy the contents of `coffee_courtyard_db.sql`
- Paste and click "Go"

### Step 4: Verify Configuration

1. Check that `includes/config.php` has correct settings:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'coffee_courtyard_db');
```

2. Ensure the uploads directory is writable:
   - Path: `coffee_courtyard/public/images/uploads/`
   - Should be automatically created with proper permissions

### Step 5: Access the Website

1. **Public Website**: `http://localhost:8080/coffee_courtyard/public/`
2. **Admin Login**: `http://localhost:8080/coffee_courtyard/admin/login.php`

### Default Admin Credentials
```
Username: admin
Password: admin123
```

**IMPORTANT**: Change these credentials after first login!

## Project Structure

```
coffee_courtyard/
│
├── admin/                          # Admin dashboard
│   ├── css/
│   │   └── admin.css              # Admin-specific styles
│   ├── auth_check.php             # Authentication middleware
│   ├── dashboard.php              # Admin dashboard home
│   ├── homepage_content.php       # Edit homepage content
│   ├── login.php                  # Admin login page
│   ├── logout.php                 # Logout handler
│   └── menu_items.php             # Menu CRUD operations
│
├── database/
│   └── coffee_courtyard_db.sql    # Database schema and sample data
│
├── includes/
│   ├── config.php                 # Configuration settings
│   ├── db.php                     # Database connection class
│   └── functions.php              # Helper functions
│
├── public/                        # Public website files
│   ├── css/
│   │   └── styles.css            # Custom styles
│   ├── js/
│   │   └── main.js               # JavaScript functionality
│   ├── images/
│   │   └── uploads/              # Uploaded images
│   └── index.php                 # Main homepage
│
└── README.md                      # This file
```

## Database Schema

### Tables

1. **admin_users**
   - `id`: Primary key
   - `username`: Admin username
   - `password_hash`: Hashed password
   - `created_at`: Account creation timestamp
   - `last_login`: Last login timestamp

2. **menu_items**
   - `id`: Primary key
   - `name`: Item name
   - `description`: Item description
   - `price`: Item price (decimal)
   - `image_path`: Path to uploaded image
   - `category`: Item category
   - `created_at`: Creation timestamp
   - `updated_at`: Last update timestamp

3. **homepage_content**
   - `id`: Primary key
   - `section_name`: Unique section identifier
   - `content_text`: Text content
   - `content_image`: Image path (optional)
   - `created_at`: Creation timestamp
   - `updated_at`: Last update timestamp

## Usage Guide

### Managing Menu Items

1. **Add New Item**:
   - Go to Admin Dashboard → Menu Items
   - Click "Add New Item"
   - Fill in name, price, category, description
   - Upload an image (optional)
   - Click "Add Menu Item"

2. **Edit Item**:
   - Click edit icon next to any item
   - Modify fields as needed
   - Upload new image or keep existing
   - Click "Update Menu Item"

3. **Delete Item**:
   - Click delete icon next to any item
   - Confirm deletion
   - Item and associated image will be removed

### Managing Homepage Content

1. Go to Admin Dashboard → Homepage Content
2. Edit sections individually:
   - Hero title and subtitle
   - About section title and text
   - Contact information
3. Click "Update" for each section
4. Preview changes by clicking "Preview Website"

## Security Features

- **SQL Injection Protection**: Prepared statements for all queries
- **Password Hashing**: bcrypt algorithm for password storage
- **Session Management**: Secure session handling
- **File Upload Validation**: Type and size restrictions
- **Input Sanitization**: All user input sanitized
- **Authentication Check**: Protected admin pages

## Customization

### Changing Colors

Edit the color scheme in both files:

**Frontend** (`public/index.php`):
```javascript
colors: {
    "primary": "#dda15e",
    "background-light": "#fefae0",
    // ... other colors
}
```

**Admin** (`admin/*.php`):
```javascript
colors: {
    "primary": "#dda15e",
    "secondary": "#283618",
    // ... other colors
}
```

### Adding New Categories

1. Edit `admin/menu_items.php`
2. Add option in category select:
```html
<option value="Your Category">Your Category</option>
```

### Modifying Homepage Sections

1. Add new section to database:
```sql
INSERT INTO homepage_content (section_name, content_text)
VALUES ('new_section', 'Content here');
```

2. Update `admin/homepage_content.php` to add edit form
3. Update `public/index.php` to display the content

## Troubleshooting

### Apache Won't Start
- Check if port 8080 is already in use
- Try a different port (e.g., 8081)
- Update config.php accordingly

### Database Connection Error
- Verify MySQL is running in XAMPP
- Check database credentials in `includes/config.php`
- Ensure database was imported correctly

### Images Not Uploading
- Check `public/images/uploads/` directory exists
- Verify directory has write permissions (777)
- Check PHP upload settings in `php.ini`

### Page Not Found (404)
- Verify project is in correct htdocs location
- Check that Apache is running on port 8080
- Use correct URL: `http://localhost:8080/coffee_courtyard/public/`

### Styling Issues
- Clear browser cache (Ctrl+F5)
- Check that TailwindCSS CDN is loading
- Verify CSS files are in correct locations

## Maintenance

### Backup Database
```sql
-- Export from phpMyAdmin or use mysqldump
mysqldump -u root coffee_courtyard_db > backup.sql
```

### Update Admin Password

1. Generate new hash:
```php
<?php
echo password_hash('new_password', PASSWORD_DEFAULT);
?>
```

2. Update in database:
```sql
UPDATE admin_users
SET password_hash = 'generated_hash'
WHERE username = 'admin';
```

### Clear Old Uploads
- Manually delete unused images from `public/images/uploads/`
- Or create cleanup script to remove orphaned images

## Support

For issues or questions:
1. Check this README carefully
2. Review code comments
3. Check XAMPP error logs
4. Verify all installation steps completed

## Credits

- **Design**: Based on mockups from stitch_home_page folder
- **Color Palette**: #dda15e, #283618, #fefae0, #606c38, #bc6c25
- **Framework**: TailwindCSS via CDN
- **Icons**: Google Material Symbols
- **Fonts**: Plus Jakarta Sans

## License

This project is created for Coffee CourtYard. All rights reserved.

---

**Version**: 1.0
**Last Updated**: 2024
**Developed for**: Coffee CourtYard Coffee Shop
