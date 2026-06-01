<?php
/**
 * Main Site Header Includes
 * Sarah Agni Personal Brand Website
 */
require_once __DIR__ . '/functions.php';

// Fallback values for SEO tags
$meta_title = isset($page_title) ? $page_title . " | Sarah Agni" : "Sarah Agni | Dreadlocks Artist & Spiritual Mentor";
$meta_desc = isset($page_description) ? $page_description : "Transform your hair, heal your energy, and ignite your spirit with Sarah Agni - India's leading dreadlocks specialist and transformational breathwork guide.";
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $meta_title; ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Sarah Agni">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($meta_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta property="og:image" content="http://<?php echo $_SERVER['HTTP_HOST']; ?>/assets/images/sarah_profile.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($meta_title); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta property="twitter:image" content="http://<?php echo $_SERVER['HTTP_HOST']; ?>/assets/images/sarah_profile.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Main Style Sheet -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Schema.org JSON-LD Structured Data for LocalBusiness & Artist -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Sarah Agni - Dreadlocks & Healing Artistry",
      "image": "http://<?php echo $_SERVER['HTTP_HOST']; ?>/assets/images/sarah_profile.png",
      "description": "Professional Dreadlocks Artist, Hypnotherapist, Breathwork Guide & Fire Dance Instructor based in India.",
      "telephone": "+919999999999",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Goa",
        "addressCountry": "IN"
      },
      "url": "http://<?php echo $_SERVER['HTTP_HOST']; ?>",
      "sameAs": [
        "https://www.instagram.com/sarah_agni",
        "https://www.facebook.com/sarah_agni",
        "https://www.youtube.com/sarah_agni"
      ],
      "priceRange": "$$",
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday"
        ],
        "opens": "09:00",
        "closes": "18:00"
      }
    }
    </script>
</head>
<body>

    <!-- Header / Navigation Bar -->
    <header class="main-header">
        <div class="header-container">
            <a href="index.php" class="logo">
                <span class="logo-accent">SARAH</span> AGNI
            </a>
            
            <!-- Desktop Navigation -->
            <nav class="desktop-nav">
                <ul>
                    <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="dreadlocks.php" class="<?php echo ($current_page == 'dreadlocks.php') ? 'active' : ''; ?>">Dreadlocks</a></li>
                    <li><a href="healing.php" class="<?php echo ($current_page == 'healing.php') ? 'active' : ''; ?>">Healing</a></li>
                    <li><a href="breathwork.php" class="<?php echo ($current_page == 'breathwork.php') ? 'active' : ''; ?>">Breathwork</a></li>
                    <li><a href="fire-dance.php" class="<?php echo ($current_page == 'fire-dance.php') ? 'active' : ''; ?>">Fire Dance</a></li>
                    <li><a href="gallery.php" class="<?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>">Gallery</a></li>
                    <li><a href="contact.php" class="nav-cta-btn <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Connect</a></li>
                </ul>
            </nav>
            
            <!-- Mobile Menu Toggle Button -->
            <button class="mobile-nav-toggle" aria-label="Toggle Navigation Menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <nav class="mobile-nav">
        <ul>
            <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a></li>
            <li><a href="dreadlocks.php" class="<?php echo ($current_page == 'dreadlocks.php') ? 'active' : ''; ?>">Dreadlocks Services</a></li>
            <li><a href="healing.php" class="<?php echo ($current_page == 'healing.php') ? 'active' : ''; ?>">Healing & Hypnotherapy</a></li>
            <li><a href="breathwork.php" class="<?php echo ($current_page == 'breathwork.php') ? 'active' : ''; ?>">Rebirth Breathwork</a></li>
            <li><a href="fire-dance.php" class="<?php echo ($current_page == 'fire-dance.php') ? 'active' : ''; ?>">Fire Dance Training</a></li>
            <li><a href="gallery.php" class="<?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>">Gallery</a></li>
            <li><a href="contact.php" class="mobile-cta-btn <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Book a Session</a></li>
        </ul>
    </nav>
