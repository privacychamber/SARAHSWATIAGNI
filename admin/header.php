<?php
/**
 * Admin Panel Header Layout
 */
require_once __DIR__ . '/../includes/functions.php';

// Protect the page - enforce session authentication
admin_require_login();

$admin_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarah Agni | Admin Dashboard</title>
    
    <!-- FontAwesome CDNs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin Styling Sheet -->
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

    <!-- Admin Top Navigation Bar -->
    <nav class="admin-navbar">
        <a href="index.php" class="admin-logo">
            <span>SARAH</span> AGNI &bull; Control
        </a>
        
        <ul class="admin-menu">
            <li><a href="index.php" class="<?php echo ($admin_page == 'index.php') ? 'active' : ''; ?>"><i class="fas fa-inbox"></i> Leads</a></li>
            <li><a href="gallery.php" class="<?php echo ($admin_page == 'gallery.php') ? 'active' : ''; ?>"><i class="fas fa-images"></i> Gallery</a></li>
            <li><a href="testimonials.php" class="<?php echo ($admin_page == 'testimonials.php') ? 'active' : ''; ?>"><i class="fas fa-comments"></i> Testimonials</a></li>
            <li><a href="content.php" class="<?php echo ($admin_page == 'content.php') ? 'active' : ''; ?>"><i class="fas fa-edit"></i> Edit Content</a></li>
            <li><a href="logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
