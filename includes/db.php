<?php
/**
 * Database Connection & Initialization
 * Sarah Agni Personal Brand Website
 */

// Database Credentials Configuration
// Modify these to match your Namecheap MySQL settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'sarah_agni_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    // Auto-install verification: If tables don't exist, create them
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'site_content'");
    if ($tableCheck->rowCount() == 0) {
        // Run SQL schema automatically to create tables
        $schemaPath = dirname(__DIR__) . '/schema.sql';
        if (file_exists($schemaPath)) {
            $sql = file_get_contents($schemaPath);
            // Execute schema query (split by semicolon if multiple statements, or execute direct)
            $pdo->exec($sql);
            
            // Seed a default administrator since it is a new install
            // Default Username: admin
            // Default Password: SarahAgni2026!
            $defaultAdmin = 'admin';
            $defaultPass = 'SarahAgni2026!';
            $hash = password_hash($defaultPass, PASSWORD_DEFAULT);
            $email = 'sarah@example.com'; // User can update in admin settings
            
            $stmt = $pdo->prepare("INSERT IGNORE INTO `users` (username, password_hash, email) VALUES (?, ?, ?)");
            $stmt->execute([$defaultAdmin, $hash, $email]);
        }
    }
    
} catch (PDOException $e) {
    // If the database itself doesn't exist, try connecting to MySQL server to create it
    try {
        $dsnNoDb = "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET;
        $pdoNoDb = new PDO($dsnNoDb, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $pdoNoDb->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        
        // Re-attempt connection
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        
        $schemaPath = dirname(__DIR__) . '/schema.sql';
        if (file_exists($schemaPath)) {
            $sql = file_get_contents($schemaPath);
            $pdo->exec($sql);
            
            $defaultAdmin = 'admin';
            $defaultPass = 'SarahAgni2026!';
            $hash = password_hash($defaultPass, PASSWORD_DEFAULT);
            $email = 'sarah@example.com';
            
            $stmt = $pdo->prepare("INSERT IGNORE INTO `users` (username, password_hash, email) VALUES (?, ?, ?)");
            $stmt->execute([$defaultAdmin, $hash, $email]);
        }
    } catch (PDOException $ex) {
        // Display a styled error message if DB connection fails
        die("
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>Database Setup Required</title>
            <style>
                body { background: #0B0B0B; color: #F6F1E9; font-family: sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
                .card { background: #151515; border: 1px solid #B67C3D; border-radius: 8px; padding: 40px; max-width: 500px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
                h1 { color: #D4AF37; margin-bottom: 20px; font-family: serif; }
                p { color: #A0A0A0; line-height: 1.6; }
                code { display: block; background: #222; padding: 10px; border-radius: 4px; color: #FF8A00; text-align: left; overflow-x: auto; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class='card'>
                <h1>Database Connection Error</h1>
                <p>Could not connect to the database. Please verify your credentials inside <code>includes/db.php</code>.</p>
                <p><strong>Error Message:</strong></p>
                <code>" . htmlspecialchars($ex->getMessage()) . "</code>
            </div>
        </body>
        </html>
        ");
    }
}
