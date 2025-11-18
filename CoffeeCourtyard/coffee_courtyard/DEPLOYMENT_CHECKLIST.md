# Coffee CourtYard - Deployment Checklist

Use this checklist to ensure your Coffee CourtYard website is properly set up and ready to use.

---

## 📋 Pre-Installation Checklist

- [ ] XAMPP downloaded and installed
- [ ] Project folder extracted
- [ ] Read SETUP_GUIDE.txt
- [ ] Have admin credentials ready

---

## ⚙️ XAMPP Configuration

- [ ] XAMPP Control Panel opened
- [ ] Apache configured for port 8080
  - [ ] httpd.conf edited
  - [ ] `Listen 8080` set
  - [ ] `ServerName localhost:8080` set
- [ ] Apache started successfully (green)
- [ ] MySQL started successfully (green)

---

## 📁 File Installation

- [ ] Project copied to htdocs folder
- [ ] Path confirmed: `htdocs/coffee_courtyard/`
- [ ] All subfolders present:
  - [ ] admin/
  - [ ] database/
  - [ ] includes/
  - [ ] public/
- [ ] Upload directory exists: `public/images/uploads/`

---

## 🗄️ Database Setup

- [ ] phpMyAdmin accessible at `localhost:8080/phpmyadmin`
- [ ] New database created: `coffee_courtyard_db`
- [ ] SQL file imported: `database/coffee_courtyard_db.sql`
- [ ] Import successful (no errors)
- [ ] Three tables created:
  - [ ] admin_users
  - [ ] menu_items
  - [ ] homepage_content
- [ ] Sample data present in tables
- [ ] Default admin user exists

---

## 🔧 Configuration Check

- [ ] `includes/config.php` exists
- [ ] Database settings correct:
  - [ ] DB_HOST = 'localhost'
  - [ ] DB_USER = 'root'
  - [ ] DB_PASS = '' (empty)
  - [ ] DB_NAME = 'coffee_courtyard_db'
- [ ] BASE_URL correct: `http://localhost:8080/coffee_courtyard`

---

## 🌐 Website Access Test

- [ ] Public website loads:
  `http://localhost:8080/coffee_courtyard/public/`
- [ ] Homepage displays correctly
- [ ] No PHP errors visible
- [ ] TailwindCSS styles loading
- [ ] Images loading (gallery section)
- [ ] Smooth scrolling works
- [ ] Navigation links work
- [ ] Menu section displays items

---

## 🔐 Admin Dashboard Test

- [ ] Admin login page loads:
  `http://localhost:8080/coffee_courtyard/admin/login.php`
- [ ] Can login with default credentials:
  - Username: `admin`
  - Password: `admin123`
- [ ] Dashboard loads after login
- [ ] Statistics display correctly
- [ ] Sidebar navigation works
- [ ] All menu links accessible

---

## 📝 Menu Items Management Test

- [ ] Menu Items page loads
- [ ] Existing items display in table
- [ ] Can click "Add New Item"
- [ ] Add form displays correctly
- [ ] Can fill out form:
  - [ ] Name field works
  - [ ] Price field works
  - [ ] Category dropdown works
  - [ ] Description textarea works
  - [ ] Image upload field works
- [ ] Can submit form
- [ ] Success message appears
- [ ] New item appears in list
- [ ] Can edit existing item
- [ ] Can delete item
- [ ] Changes reflect on public website

---

## 🏠 Homepage Content Management Test

- [ ] Homepage Content page loads
- [ ] All sections visible:
  - [ ] Hero Section
  - [ ] About Section
  - [ ] Contact Information
- [ ] Can edit hero title
- [ ] Can edit hero subtitle
- [ ] Can edit about text
- [ ] Can edit contact details
- [ ] Updates save successfully
- [ ] Changes show on public website
- [ ] Preview button works

---

## 🖼️ Image Upload Test

- [ ] Can select image file
- [ ] Image preview appears
- [ ] File type validation works
- [ ] File size validation works
- [ ] Image uploads successfully
- [ ] Image saves to `uploads/` folder
- [ ] Image displays on website
- [ ] Image displays in admin list

---

## 📱 Responsive Design Test

- [ ] Desktop view (1920px):
  - [ ] Layout correct
  - [ ] All elements visible
  - [ ] Navigation works
- [ ] Tablet view (768px):
  - [ ] Layout adapts
  - [ ] Readable text
  - [ ] Images scale
- [ ] Mobile view (375px):
  - [ ] Layout stacks properly
  - [ ] Touch-friendly buttons
  - [ ] All content accessible

---

## 🔒 Security Verification

- [ ] Cannot access admin without login
- [ ] Login required for dashboard
- [ ] Login required for menu management
- [ ] Login required for content management
- [ ] Logout works properly
- [ ] Session expires correctly
- [ ] SQL injection test passed (admin inputs)
- [ ] XSS test passed (no script execution)
- [ ] File upload validates types
- [ ] Password is hashed in database

---

## 🎨 Design Verification

- [ ] Coffee theme colors applied:
  - [ ] Primary: #dda15e ✓
  - [ ] Secondary: #283618 ✓
  - [ ] Background: #fefae0 ✓
  - [ ] Accent: #bc6c25 ✓
- [ ] Plus Jakarta Sans font loads
- [ ] Material icons display
- [ ] Smooth animations work
- [ ] Hover effects work
- [ ] Overall design matches mockups

---

## ✅ Final Checks

- [ ] No console errors (F12 in browser)
- [ ] No PHP errors displayed
- [ ] All images loading
- [ ] All links working
- [ ] Forms submitting correctly
- [ ] Data saving to database
- [ ] Changes persisting after refresh
- [ ] Multiple browsers tested:
  - [ ] Chrome
  - [ ] Firefox
  - [ ] Edge
  - [ ] Safari (if Mac)

---

## 📝 Post-Setup Tasks

- [ ] Change admin password:
  1. [ ] Generate new password hash
  2. [ ] Update in database
  3. [ ] Test new login
- [ ] Add real menu items:
  - [ ] Delete sample items
  - [ ] Add actual products
  - [ ] Upload real images
- [ ] Update homepage content:
  - [ ] Edit hero section
  - [ ] Update about text
  - [ ] Add real contact info
  - [ ] Update social links
- [ ] Create database backup
- [ ] Test all functionality again
- [ ] Document any custom changes

---

## 🎯 Optional Enhancements

- [ ] Add more admin users
- [ ] Create additional menu categories
- [ ] Add more homepage sections
- [ ] Customize colors
- [ ] Add analytics code
- [ ] Set up contact form email
- [ ] Add more social media links
- [ ] Optimize images
- [ ] Add favicon
- [ ] Enable HTTPS (for production)

---

## 📞 Troubleshooting Reference

### Apache Won't Start
1. Check if port 8080 is in use
2. Try different port
3. Update config.php with new port

### Database Connection Failed
1. Verify MySQL is running
2. Check credentials in config.php
3. Ensure database was imported

### 404 Page Not Found
1. Check folder location
2. Verify URL includes port 8080
3. Check Apache is running

### Images Won't Upload
1. Check uploads folder exists
2. Verify folder permissions
3. Check file size (max 5MB)
4. Verify file type (jpg, png, gif, webp)

### Styles Not Loading
1. Clear browser cache
2. Check internet connection (CDN)
3. Verify CSS files exist
4. Check browser console

---

## ✨ Completion Status

Once all checkboxes are marked, your Coffee CourtYard website is:
- ✅ Properly installed
- ✅ Fully configured
- ✅ Tested and verified
- ✅ Ready to use!

---

## 📚 Next Steps

1. Explore the admin dashboard
2. Add your real menu items
3. Customize content
4. Share with stakeholders
5. Gather feedback
6. Make adjustments

---

**Questions?** Check `README.md` for detailed documentation!

**Need Help?** Review code comments for implementation details!

---

**Congratulations on your new website!** ☕🎉
