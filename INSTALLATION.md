# Namecheap Shared Hosting - Installation & Security Guide

This website is custom-engineered using vanilla **PHP 8+** and **MySQL**. It runs directly on Namecheap Shared Hosting (Stellar, Stellar Plus, or Stellar Business plans) without requiring Node.js, npm, Composer, Docker, SSH, or server-side dependencies.

---

## 1. Fast Deployment Steps

### Step A: Upload Files
1. Log in to your **Namecheap cPanel**.
2. Open the **File Manager** and navigate to your web root directory (usually `public_html` for your primary domain, or a custom folder if using an addon domain).
3. Upload the entire project directory structure (keep paths intact: `admin/`, `assets/`, `includes/`, `uploads/`, `index.php`, etc.).

### Step B: Create a MySQL Database
1. In cPanel, search for and open the **MySQL Database Wizard**.
2. **Step 1: Create a Database**: Type a name (e.g. `sarah_db`) and click *Next*.
3. **Step 2: Create Database Users**: Type a username (e.g. `sarah_user`) and a secure password. Click *Create User*. Keep these details copied!
4. **Step 3: Add User to Database**: Tick **ALL PRIVILEGES** to link the user to the database, then click *Next*.

### Step C: Configure Database Connection
1. Open the File Manager and edit [db.php](file:///d:/SarahAgni/includes/db.php) (located in `/includes/db.php`).
2. Update the credentials at the top of the file:
   ```php
   define('DB_HOST', 'localhost'); // Keep as localhost on Namecheap
   define('DB_NAME', 'your_cpanel_db_name');
   define('DB_USER', 'your_cpanel_user_name');
   define('DB_PASS', 'your_cpanel_password');
   ```
3. Save the file.

### Step D: Automatic Schema Compiler
We built an automatic compiler directly into the database connection loader.
- Simply open your website in any browser (e.g. `https://yourdomain.com`).
- The script checks if tables exist. If empty, it reads `schema.sql` and imports all tables and default page contents automatically.
- *Alternatively*: You can manually import `schema.sql` inside cPanel **phpMyAdmin** if you prefer.

---

## 2. Admin Credentials & Setup

- **Admin Login Page**: `https://yourdomain.com/admin/login.php`
- **Default Username**: `admin`
- **Default Password**: `SarahAgni2026!`

> [!WARNING]
> **Change Default Password immediately** upon first login!
> To update the password:
> 1. Go to **phpMyAdmin** in your Namecheap cPanel.
> 2. Open the `users` table.
> 3. Click **Edit** on the `admin` row.
> 4. In the `password_hash` column, write your new password. Set the function dropdown selector of that field to **BCRYPT** or **MD5** (or run a quick PHP password_hash script) and click **Go** to save.

---

## 3. Directory Permissions

Ensure the following folders have correct permission codes set inside the File Manager:
- `/uploads/` -> **755** (Owner: Read/Write/Execute, Group: Read/Execute, World: Read/Execute). This permits secure image uploads via cPanel's Apache configuration.
- All `.php` pages -> **644**.

---

## 4. Hardening & Security Recommendations

### Recommendation 1: Rename the Admin Directory
Because this is built on a clean relative-path architecture, you can rename the `/admin/` folder to anything you want (e.g., `/sarah-inbox/` or `/secure-panel/`) to immediately block bots from scanning for login paths. 
- Log into cPanel File Manager.
- Right-click the `admin` folder and select **Rename**.
- Change it to your private name. All navigation links and dashboard files will adjust automatically!

### Recommendation 2: Deny Direct Directory Crawling
We include a `robots.txt` that blocks crawlers, but you should also block directory listing in Apache. Create or open your root `.htaccess` file in `public_html` and append:
```apache
# Prevent directory listings
Options -Indexes

# Protect db.php and includes
<FilesMatch "^\.(php|ini|log|sql)">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### Recommendation 3: Set up SSL Redirects
Ensure users are redirected to secure HTTPS. Add this at the top of your root `.htaccess`:
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```
Namecheap supplies free **cPanel AutoSSL** certificates. Ensure it is turned on in cPanel under **SSL/TLS Status** for your domain.
