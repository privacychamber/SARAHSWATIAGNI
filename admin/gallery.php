<?php
/**
 * Admin Panel Gallery Manager
 */
require_once __DIR__ . '/header.php';

$success = "";
$error = "";

// 1. Handle Upload Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload') {
    $csrf_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    
    if (!verify_csrf_token($csrf_token)) {
        $error = "CSRF verification failed. Try again.";
    } else {
        $title = sanitize_input($_POST['title'] ?? '');
        $category = sanitize_input($_POST['category'] ?? '');
        
        if (empty($title) || empty($category) || !isset($_FILES['image'])) {
            $error = "All fields and an image file are required.";
        } else {
            // Safe upload via functions helper
            $upload_res = upload_image($_FILES['image'], '../uploads/');
            
            if ($upload_res['success']) {
                $image_path = $upload_res['path'];
                
                try {
                    $stmt = $pdo->prepare("INSERT INTO gallery (title, category, image_path) VALUES (?, ?, ?)");
                    $stmt->execute([$title, $category, $image_path]);
                    $success = "Image uploaded and cataloged successfully.";
                } catch (PDOException $e) {
                    // Clean up uploaded file if DB insertion failed
                    @unlink('../' . $image_path);
                    $error = "Failed to log image in database: " . $e->getMessage();
                }
            } else {
                $error = $upload_res['message'];
            }
        }
    }
}

// 2. Handle Delete Request
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $item_id = (int)$_GET['id'];
    
    try {
        // Fetch the file path first to delete the file on Namecheap hosting storage
        $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
        $stmt->execute([$item_id]);
        $item = $stmt->fetch();
        
        if ($item) {
            $file_path = '../' . $item['image_path'];
            // Delete actual file
            if (file_exists($file_path)) {
                @unlink($file_path);
            }
            
            // Delete database reference
            $delete_stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
            $delete_stmt->execute([$item_id]);
            $success = "Image deleted successfully from database and server storage.";
        } else {
            $error = "Gallery item not found.";
        }
    } catch (PDOException $e) {
        $error = "Delete failed: " . $e->getMessage();
    }
}

// Fetch all gallery items
try {
    $gallery_items = get_gallery_items();
} catch (PDOException $e) {
    $gallery_items = [];
    $error = "Could not fetch items: " . $e->getMessage();
}

$token = generate_csrf_token();
?>

<div class="admin-container">
    <div class="admin-header-row">
        <h2>Manage Media Gallery</h2>
        <a href="#upload-form" class="admin-btn">Add New Photo</a>
    </div>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="admin-row">
        <!-- Display Current Gallery -->
        <div class="admin-card">
            <h3>Current Gallery Items (<?php echo count($gallery_items); ?>)</h3>
            
            <?php if (empty($gallery_items)): ?>
                <p style="color: var(--color-admin-muted);">No images uploaded to the database yet. Default fallback images are showing on the main site.</p>
            <?php else: ?>
                <div class="gallery-manager-grid">
                    <?php foreach ($gallery_items as $item): ?>
                        <div class="gallery-manage-card">
                            <img src="../<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="gallery-manage-thumb">
                            <div class="gallery-manage-details">
                                <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                                <span>Category: <?php echo htmlspecialchars($item['category']); ?></span>
                                <a href="gallery.php?action=delete&id=<?php echo $item['id']; ?>" 
                                   class="admin-btn admin-btn-danger" 
                                   style="width: 100%; text-align: center; display: block;" 
                                   onclick="return confirm('Are you sure you want to delete this image from server database and host storage?');">
                                   <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Upload Form -->
        <div class="admin-card" id="upload-form">
            <h3>Upload New Media</h3>
            
            <form action="gallery.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                <input type="hidden" name="action" value="upload">
                
                <div class="admin-form-group">
                    <label for="title">Image Title *</label>
                    <input type="text" id="title" name="title" class="admin-form-control" placeholder="e.g. Master Dreadlock Sectioning" required>
                </div>
                
                <div class="admin-form-group">
                    <label for="category">Category *</label>
                    <select id="category" name="category" class="admin-form-control" required>
                        <option value="dreadlocks">Dreadlocks (Primary Revenue)</option>
                        <option value="firedance">Fire Dance</option>
                        <option value="healing">Healing Sessions</option>
                        <option value="workshops">Workshops</option>
                        <option value="events">Events</option>
                    </select>
                </div>
                
                <div class="admin-form-group">
                    <label for="image">Choose Image (Max size: 5MB. Formats: JPG, PNG, WEBP) *</label>
                    <input type="file" id="image" name="image" class="admin-form-control" accept="image/*" required style="border: none; padding: 10px 0;">
                </div>
                
                <button type="submit" class="admin-btn" style="width: 100%;">Upload & Save</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
