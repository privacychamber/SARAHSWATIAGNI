<?php
/**
 * Core Helper Functions
 * Sarah Agni Personal Brand Website
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

/**
 * Sanitize user input for display to prevent XSS
 */
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Get dynamic content value from site_content table
 * Uses static caching to avoid multiple database calls for the same page request
 */
function get_content($key, $default = '') {
    global $pdo;
    static $cached_content = null;
    
    if ($cached_content === null) {
        $cached_content = [];
        try {
            $stmt = $pdo->query("SELECT key_name, field_value FROM site_content");
            while ($row = $stmt->fetch()) {
                $cached_content[$row['key_name']] = $row['field_value'];
            }
        } catch (PDOException $e) {
            // Silence or log database error during installation
        }
    }
    
    return isset($cached_content[$key]) ? $cached_content[$key] : $default;
}

/**
 * Update dynamic content value in database
 */
function update_content($key, $value) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO site_content (key_name, field_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE field_value = ?");
    return $stmt->execute([$key, $value, $value]);
}

/**
 * Check if administrator is logged in
 */
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Enforce administrator authentication on administrative pages
 */
function admin_require_login() {
    if (!is_admin_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

/**
 * Generate CSRF token for forms
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Handle secure image upload
 * Checks MIME type, size limit, and renames file to prevent collision and script injection
 */
function upload_image($file, $target_dir = '../uploads/') {
    // Ensure upload directory exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Upload error occurred: ' . $file['error']];
    }
    
    // Validate File Size (Limit to 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        return ['success' => false, 'message' => 'File size exceeds maximum limit of 5MB.'];
    }
    
    // Validate File Type (MIME and Extension checks)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $file_info = getimagesize($file['tmp_name']);
    
    if ($file_info === false || !in_array($file_info['mime'], $allowed_types)) {
        return ['success' => false, 'message' => 'Invalid file format. Only JPG, PNG, GIF, and WEBP images are allowed.'];
    }
    
    // Generate secure unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = bin2hex(random_bytes(16)) . '.' . strtolower($extension);
    $target_file = $target_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return ['success' => true, 'filename' => $filename, 'path' => 'uploads/' . $filename];
    }
    
    return ['success' => false, 'message' => 'Failed to save the uploaded image. Check directory permissions.'];
}

/**
 * Fetch testimonials
 */
function get_testimonials($limit = null, $featured_only = false) {
    global $pdo;
    $sql = "SELECT * FROM testimonials";
    $params = [];
    
    if ($featured_only) {
        $sql .= " WHERE is_featured = 1";
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    if ($limit !== null) {
        $sql .= " LIMIT " . (int)$limit;
    }
    
    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Fetch gallery items
 */
function get_gallery_items($category = null) {
    global $pdo;
    $sql = "SELECT * FROM gallery";
    $params = [];
    
    if ($category !== null && $category !== 'all') {
        $sql .= " WHERE category = ?";
        $params[] = $category;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}
