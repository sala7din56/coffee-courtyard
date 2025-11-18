# Coffee CourtYard - Admin Quick Reference

Quick reference guide for daily admin tasks.

---

## 🔐 Login Information

**Admin Login URL**: `http://localhost:8080/coffee_courtyard/admin/login.php`

**Default Credentials**:
- Username: `admin`
- Password: `admin123`

⚠️ **IMPORTANT**: Change password after first login!

---

## 📍 Important URLs

| Page | URL |
|------|-----|
| Public Website | `http://localhost:8080/coffee_courtyard/public/` |
| Admin Login | `http://localhost:8080/coffee_courtyard/admin/login.php` |
| Dashboard | `http://localhost:8080/coffee_courtyard/admin/dashboard.php` |
| Menu Items | `http://localhost:8080/coffee_courtyard/admin/menu_items.php` |
| Homepage Content | `http://localhost:8080/coffee_courtyard/admin/homepage_content.php` |

---

## ☕ Managing Menu Items

### Add New Menu Item

1. Go to: Menu Items → Add New Item
2. Fill in required fields:
   - Item Name *
   - Price * (in dollars)
   - Category *
3. Optional:
   - Description
   - Image (JPG, PNG, GIF, WebP - max 5MB)
4. Click "Add Menu Item"

### Edit Existing Item

1. Go to: Menu Items
2. Click ✏️ (edit icon) next to item
3. Update fields as needed
4. Click "Update Menu Item"

### Delete Item

1. Go to: Menu Items
2. Click 🗑️ (delete icon) next to item
3. Confirm deletion
4. Item and image will be permanently removed

### Menu Categories

Available categories:
- Hot Coffee
- Iced Drinks
- Pastries
- Food
- Tea

---

## 🏠 Managing Homepage Content

### Edit Hero Section

1. Go to: Homepage Content
2. Find "Hero Section"
3. Update:
   - Hero Title (main headline)
   - Hero Subtitle (description)
4. Click "Update" button for each

### Edit About Section

1. Go to: Homepage Content
2. Find "About Section"
3. Update:
   - About Title
   - About Text (your story)
4. Click "Update" button for each

### Edit Contact Information

1. Go to: Homepage Content
2. Find "Contact Information"
3. Update:
   - Address
   - Email
   - Phone
4. Click "Update" button for each

---

## 🖼️ Image Guidelines

### Best Practices
- **Format**: JPG or PNG preferred
- **Size**: Max 5MB per image
- **Dimensions**: 800x800px recommended (square)
- **Quality**: High quality, but optimized
- **Content**: Clear, well-lit product photos

### Supported Formats
✅ JPG/JPEG
✅ PNG
✅ GIF
✅ WebP

❌ PDF, DOC, or other formats

---

## ⚡ Quick Tasks

### View Live Website
Click "View Website" in sidebar or:
`http://localhost:8080/coffee_courtyard/public/`

### Preview Changes
After editing content, click "Preview Website" to see changes

### Logout
Click logout icon (🚪) in sidebar footer

### Dashboard Statistics
View on Dashboard:
- Total menu items
- Homepage sections
- Admin users

---

## 🎨 Customization Tips

### Pricing
- Use consistent decimal format: `4.50` not `4.5`
- Include cent values: `3.00` not just `3`

### Descriptions
- Keep concise (1-2 sentences)
- Focus on unique features
- Mention key ingredients
- Use appetizing language

### Categories
- Use provided categories for consistency
- Group similar items together
- Consider seasonal categories

### Images
- Show final product
- Good lighting
- Simple background
- Consistent style across menu

---

## ⚠️ Common Issues

### Can't Login
- Check username/password spelling
- Ensure Caps Lock is off
- Try default credentials if changed password

### Changes Not Showing
- Clear browser cache (Ctrl+F5)
- Check if saved successfully
- Refresh public website

### Image Won't Upload
- Check file size (under 5MB)
- Verify file type (JPG, PNG, GIF, WebP)
- Try different image

### Item Not Displaying
- Check category spelling
- Verify item was saved
- Check database connection

---

## 🔒 Security Best Practices

### Password Management
1. Use strong password
2. Don't share credentials
3. Change password regularly
4. Logout when done

### Data Backup
1. Export database monthly
2. Save uploaded images
3. Keep backup off-site
4. Test restore process

### Safe Operations
1. Preview before publishing
2. Backup before major changes
3. Test on sample item first
4. Double-check before deleting

---

## 📊 Content Strategy

### Menu Organization
- Organize by meal time (breakfast, lunch)
- Group by type (drinks, food, pastries)
- Highlight popular items
- Update seasonal offerings

### Pricing Strategy
- Competitive pricing
- Consistent increments
- Consider combo deals
- Update regularly

### Content Updates
- Refresh about section quarterly
- Update contact info as needed
- Add seasonal content
- Keep menu current

---

## 🎯 Daily Workflow

### Morning Routine
1. ✅ Login to admin
2. ✅ Check dashboard stats
3. ✅ Review menu items
4. ✅ Update any changes
5. ✅ Preview website

### Adding New Item
1. ✅ Prepare item details
2. ✅ Take/optimize photo
3. ✅ Login to admin
4. ✅ Add new menu item
5. ✅ Preview on website
6. ✅ Verify appearance

### Updating Content
1. ✅ Note required changes
2. ✅ Login to admin
3. ✅ Navigate to section
4. ✅ Make edits
5. ✅ Save changes
6. ✅ Preview website
7. ✅ Verify updates

---

## 🆘 Getting Help

### Documentation
- **Complete Guide**: `README.md`
- **Setup Help**: `SETUP_GUIDE.txt`
- **This Guide**: `ADMIN_QUICK_REFERENCE.md`

### Troubleshooting
- Check XAMPP is running
- Verify database connection
- Clear browser cache
- Review error messages

### Code Comments
All PHP files contain detailed comments explaining functionality.

---

## 💡 Pro Tips

### Efficiency
- Use keyboard shortcuts (Ctrl+S to save)
- Keep images ready before uploading
- Batch similar updates together
- Preview before publishing

### Quality
- Spell-check all content
- Use consistent capitalization
- Proofread descriptions
- Test all changes

### Organization
- Use descriptive item names
- Keep categories consistent
- Regular content audits
- Archive old items

---

## 📞 Quick Reference Card

| Task | Steps |
|------|-------|
| **Add Item** | Menu Items → Add → Fill Form → Upload Image → Save |
| **Edit Item** | Menu Items → Edit Icon → Update → Save |
| **Delete Item** | Menu Items → Delete Icon → Confirm |
| **Edit Hero** | Homepage Content → Hero Section → Update |
| **Edit About** | Homepage Content → About Section → Update |
| **Edit Contact** | Homepage Content → Contact Info → Update |
| **Preview** | Click "Preview Website" or "View Website" |
| **Logout** | Click logout icon in sidebar |

---

## ✅ Before You Publish

Daily checklist:
- [ ] Content proofread
- [ ] Images optimized
- [ ] Prices correct
- [ ] Categories assigned
- [ ] Changes saved
- [ ] Website previewed
- [ ] Logout completed

---

**Remember**: Your changes are live immediately after saving!

**Bookmark this page** for quick reference! 📌

---

*For detailed information, always refer to the complete README.md file.*
