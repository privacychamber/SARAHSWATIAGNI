<?php
/**
 * Admin Secure Login Portal
 */
require_once __DIR__ . '/../includes/functions.php';

// Redirect if already authenticated
if (is_admin_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    
    if (!verify_csrf_token($csrf_token)) {
        $error = "CSRF validation failed. Refresh the page and try again.";
    } else {
        $username = sanitize_input($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error = "Please fill in all credential fields.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password_hash'])) {
                    // Session Registration
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_username'] = $user['username'];
                    $_SESSION['admin_email'] = $user['email'];
                    
                    // Reset CSRF token for security after successful auth
                    unset($_SESSION['csrf_token']);
                    
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Invalid username or password configuration.";
                }
            } catch (PDOException $e) {
                $error = "Database validation error: " . $e->getMessage();
            }
        }
    }
}

// Generate new CSRF token
$token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarah Agni | Secure Admin Login</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body style="background: #050505;">

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h1>SARAH AGNI</h1>
                <p>Administrative Control</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form action="login.php" method="POST" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                
                <div class="admin-form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="admin-form-control" placeholder="admin" required autocomplete="username">
                </div>
                
                <div class="admin-form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="admin-form-control" placeholder="••••••••••••" required autocomplete="current-password">
                </div>
                
                <button type="submit" class="admin-btn" style="width: 100%; margin-top: 15px;">Secure Login</button>
            </form>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="../index.php" style="color: var(--color-admin-muted); font-size: 0.8rem; text-decoration: none;">&larr; Return to Main Site</a>
            </div>
        </div>
    </div>

</body>
</html>
