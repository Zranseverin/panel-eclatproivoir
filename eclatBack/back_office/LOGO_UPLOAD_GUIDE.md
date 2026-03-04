# Logo Upload Guide - Navbar Brand Management

## ✅ Feature Added: Logo File Upload

You can now upload logo images directly through the admin panel instead of just entering file paths manually.

---

## 🎯 How to Upload a Logo

### Method 1: Upload New Logo (Recommended)

1. **Go to Admin Panel**
   ```
   http://localhost:8000/admin/navbar-brands
   ```

2. **Create New Configuration or Edit Existing**
   - Click "Add New Configuration" to create new
   - OR click "Edit" (pencil icon) on existing configuration

3. **Upload Logo File**
   - Click "Choose File" button under "Upload Logo Image"
   - Select your logo image (PNG, JPG, GIF)
   - File size must be less than 2MB
   - Preview appears automatically

4. **Fill Other Fields**
   - Logo Alt Text: Description for accessibility
   - Brand Name: Company name
   - Brand URL: Where logo links to
   - Logo Height: Display size in pixels (10-500)

5. **Save**
   - Click "Create Configuration" or "Update Configuration"
   - Logo is automatically saved to `storage/app/public/navbar_brands/`
   - Visible immediately on frontend

### Method 2: Enter Path Manually

If you already have a logo file uploaded via FTP/cPanel:

1. Enter relative path in "Or Enter Logo Path Manually" field
   - Example: `img/logo.jpg`, `assets/brand.png`
2. Fill other fields
3. Save

---

## 📋 Supported File Types & Limits

### Accepted Formats
- ✅ PNG (.png)
- ✅ JPEG/JPG (.jpg, .jpeg)
- ✅ GIF (.gif)

### File Size Limit
- **Maximum:** 2MB (2048KB)
- **Recommended:** Under 500KB for faster loading

### Image Dimensions
- **Minimum:** 100x100 pixels
- **Recommended:** 400x200 pixels (for good quality at 100px height)
- **Maximum:** No limit, but large images are not optimized automatically

---

## 🗂️ File Storage

### Where Logos Are Stored
```
storage/app/public/navbar_brands/
├── 1709500000_company_logo.png
├── 1709500100_brand_name.jpg
└── ...
```

### Access URL
Uploaded files are accessible at:
```
http://localhost:8000/storage/navbar_brands/[filename]
```

### Creating Symbolic Link
If images don't appear, create storage link:
```bash
docker-compose exec app php artisan storage:link
```

---

## 🖼️ Logo Preview Feature

### Create Form
- Shows preview after selecting file
- Displays filename
- Validates file type and size before upload

### Edit Form
- Shows current logo (if exists)
- Shows preview of new logo when file selected
- Compares old vs new

---

## 🔄 Updating Logo

### To Replace Existing Logo:

1. Go to edit form
2. See "Current Logo" section with existing logo displayed
3. Click "Upload New Logo Image"
4. Select new file
5. "New Logo Preview" appears
6. Save changes
7. Old logo is automatically deleted from server

### To Keep Existing Logo:

1. Go to edit form
2. Don't upload new file
3. Modify other fields (alt text, height, etc.)
4. Save
5. Logo remains unchanged

---

## 🛠️ Validation Rules

### On Upload
- ✅ Must be image file
- ✅ Max 2MB file size
- ✅ Allowed formats: PNG, JPG, GIF

### Auto-Validation
- ✅ File type checked before upload
- ✅ File size checked before upload
- ✅ Error messages shown immediately

---

## 📊 What Happens Behind the Scenes

### Create Operation
```
1. User selects file
2. Form validates (type, size)
3. Preview shown
4. Submit → Controller receives file
5. File renamed: timestamp_originalname.ext
6. Stored in: storage/app/public/navbar_brands/
7. Path saved to database: storage/navbar_brands/filename
8. Accessible at: http://localhost:8000/storage/...
```

### Update Operation
```
1. User uploads new file
2. Old file deleted (if in storage folder)
3. New file saved
4. Database updated with new path
5. Frontend shows new logo immediately
```

### Delete Operation
```
1. User deletes configuration
2. If logo is in storage folder → deleted
3. Database record removed
4. Logo no longer accessible
```

---

## 🎨 Best Practices

### Logo Optimization
1. **Compress Images**
   - Use TinyPNG, Compressor.io, or similar tools
   - Keep under 200KB if possible

2. **Correct Dimensions**
   - Export at 2x display size for retina screens
   - Example: For 100px display, upload 200px height

3. **Transparent Background**
   - Use PNG format for transparent backgrounds
   - Better integration with navbar colors

4. **Descriptive Alt Text**
   - Include company name
   - Example: "EPI - Eclat Pro Ivoire Logo"

5. **Consistent Naming**
   - Use descriptive filenames
   - Example: `company-logo-primary.png` not `image123.png`

---

## 🔧 Troubleshooting

### Problem: Upload button doesn't work
**Solution:**
- Check form has `enctype="multipart/form-data"`
- Verify JavaScript console for errors
- Clear browser cache

### Problem: "Failed to upload" error
**Possible Causes:**
1. File too large (>2MB)
2. Wrong file type
3. Insufficient permissions

**Solution:**
```bash
# Check storage folder permissions
chmod -R 775 storage/app/public/navbar_brands/

# Or recreate storage link
docker-compose exec app php artisan storage:link
```

### Problem: Logo not displaying after upload
**Solutions:**
1. **Check if file exists**
   ```bash
   ls -la storage/app/public/navbar_brands/
   ```

2. **Verify storage link**
   ```bash
   docker-compose exec app php artisan storage:link
   ```

3. **Check database path**
   ```sql
   SELECT logo_path FROM navbar_brands WHERE is_active = 1;
   ```

4. **Clear browser cache**
   - Ctrl+Shift+Delete
   - Or hard refresh: Ctrl+F5

### Problem: Old logo still showing
**Cause:** Browser cache

**Solution:**
1. Hard refresh browser (Ctrl+F5)
2. Clear browser cache
3. Or add version parameter: `logo.png?v=2`

---

## 💡 Advanced Features

### Automatic Filename Sanitization
Files are automatically renamed to prevent conflicts:
```
Original: My Logo (Final).png
Stored as: 1709500000_my_logo_final.png
```

### Old File Cleanup
When updating logo:
- ✅ Old file automatically deleted
- ✅ Only if in storage folder
- ✅ Manual paths not affected

### Multiple Configurations
You can have multiple brand configurations:
- Different logos for different seasons
- Test multiple designs
- Switch between them easily

Only ONE can be active at a time.

---

## 📝 Example Workflow

### Scenario: Company Rebranding

1. **Prepare New Logo**
   - Design team provides: `new-brand-logo-2024.png`
   - Size: 800x400px (optimized to 150KB)

2. **Upload to Test Configuration**
   - Create new configuration
   - Upload logo file
   - Set as inactive
   - Preview on test page

3. **Review & Adjust**
   - Check logo height (adjust to 120px)
   - Update alt text
   - Verify mobile appearance

4. **Go Live**
   - Edit main configuration
   - Upload new logo
   - Old logo automatically deleted
   - Save changes

5. **Verify**
   - Refresh homepage
   - Check all pages
   - Test on mobile devices

---

## 🌐 API Usage

### Upload via API

```bash
curl -X POST http://localhost:8000/api/v1/navbar-brands \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "logo_upload=@/path/to/logo.png" \
  -F "logo_alt=Company Logo" \
  -F "brand_name=Company Name" \
  -F "is_active=1"
```

---

## 📁 Files Modified

### Views Updated
- ✅ `create.blade.php` - Added file upload input + preview
- ✅ `edit.blade.php` - Added file upload + current logo display

### Controllers Updated
- ✅ `NavbarBrandController.php` - Added file handling logic
  - `store()` method - Handles upload
  - `update()` method - Replaces old file

### No Changes Needed
- ❌ Model (works as-is)
- ❌ Migration (no schema changes)
- ❌ Routes (same endpoints)
- ❌ Frontend (automatic updates)

---

## ✅ Summary

**Before:** Had to manually upload logo via FTP and enter path  
**After:** Can upload directly in admin panel with preview

**Benefits:**
- ✅ No FTP needed
- ✅ Instant preview
- ✅ Automatic validation
- ✅ Old file cleanup
- ✅ User-friendly interface
- ✅ Secure file handling

---

**Status:** ✅ Complete and Ready to Use!

**Last Updated:** March 3, 2026
