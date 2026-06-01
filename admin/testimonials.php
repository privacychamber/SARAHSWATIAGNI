<?php
/**
 * Admin Panel Testimonials Manager
 */
require_once __DIR__ . '/header.php';

$success = "";
$error = "";

// Initialize variables for edit mode
$edit_mode = false;
$edit_id = 0;
$client_name = "";
$role_or_title = "";
$star_rating = 5;
$testimonial_text = "";
$video_url = "";
$is_featured = 0;

// 1. Handle Delete Request
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Testimonial deleted successfully.";
    } catch (PDOException $e) {
        $error = "Failed to delete testimonial: " . $e->getMessage();
    }
}

// 2. Handle Edit Trigger (Retrieve values to form)
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = (int)$_GET['edit'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
        $stmt->execute([$edit_id]);
        $t = $stmt->fetch();
        if ($t) {
            $client_name = $t['client_name'];
            $role_or_title = $t['role_or_title'];
            $star_rating = $t['star_rating'];
            $testimonial_text = $t['testimonial_text'];
            $video_url = $t['video_url'];
            $is_featured = $t['is_featured'];
        } else {
            $edit_mode = false;
            $error = "Testimonial not found for editing.";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}

// 3. Handle Form POST Submission (Add or Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    
    if (!verify_csrf_token($csrf_token)) {
        $error = "CSRF verification failed. Try again.";
    } else {
        $client_name = sanitize_input($_POST['client_name'] ?? '');
        $role_or_title = sanitize_input($_POST['role_or_title'] ?? '');
        $star_rating = (int)($_POST['star_rating'] ?? 5);
        $testimonial_text = sanitize_input($_POST['testimonial_text'] ?? '');
        $video_url = sanitize_input($_POST['video_url'] ?? '');
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        
        if (empty($client_name) || empty($testimonial_text)) {
            $error = "Client Name and Testimonial Text are required.";
        } else {
            try {
                if ($edit_mode) {
                    // Update Query
                    $stmt = $pdo->prepare("UPDATE testimonials SET client_name = ?, role_or_title = ?, star_rating = ?, testimonial_text = ?, video_url = ?, is_featured = ? WHERE id = ?");
                    $stmt->execute([$client_name, $role_or_title, $star_rating, $testimonial_text, $video_url, $is_featured, $edit_id]);
                    $success = "Testimonial updated successfully.";
                    $edit_mode = false; // Reset edit state
                } else {
                    // Insert Query
                    $stmt = $pdo->prepare("INSERT INTO testimonials (client_name, role_or_title, star_rating, testimonial_text, video_url, is_featured) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$client_name, $role_or_title, $star_rating, $testimonial_text, $video_url, $is_featured]);
                    $success = "Testimonial created successfully.";
                }
                
                // Clear fields
                $client_name = $role_or_title = $testimonial_text = $video_url = "";
                $star_rating = 5;
                $is_featured = 0;
                
            } catch (PDOException $e) {
                $error = "Database operations failed: " . $e->getMessage();
            }
        }
    }
}

// Fetch all testimonials
try {
    $testimonials = get_testimonials();
} catch (PDOException $e) {
    $testimonials = [];
    $error = "Could not retrieve reviews: " . $e->getMessage();
}

$token = generate_csrf_token();
?>

<div class="admin-container">
    <div class="admin-header-row">
        <h2>Manage Client Testimonials</h2>
    </div>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="admin-row">
        <!-- List Panel -->
        <div class="admin-card">
            <h3>Logged Testimonials (<?php echo count($testimonials); ?>)</h3>
            
            <?php if (empty($testimonials)): ?>
                <p style="color: var(--color-admin-muted);">No testimonials logged. Displaying default client reviews on the homepage.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Rating</th>
                                <th>Name</th>
                                <th>Testimonial Text</th>
                                <th>Featured?</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($testimonials as $t): ?>
                                <tr>
                                    <td style="color: var(--color-admin-gold); white-space: nowrap;">
                                        <?php for($i=0; $i<$t['star_rating']; $i++): ?>★<?php endfor; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($t['client_name']); ?></strong><br>
                                        <span style="font-size: 0.8rem; color: var(--color-admin-muted);"><?php echo htmlspecialchars($t['role_or_title']); ?></span>
                                    </td>
                                    <td style="font-size: 0.85rem; max-width: 250px; white-space: normal;">
                                        "<?php echo htmlspecialchars($t['testimonial_text']); ?>"
                                        <?php if (!empty($t['video_url'])): ?>
                                            <br><a href="<?php echo htmlspecialchars($t['video_url']); ?>" target="_blank" style="font-size: 0.75rem; color: #ff8a00;"><i class="fab fa-youtube"></i> Video Review</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo $t['is_featured'] ? '<span class="badge badge-unread">Home Page</span>' : '<span class="badge badge-read">Hidden</span>'; ?>
                                    </td>
                                    <td>
                                        <div class="btn-actions-cell">
                                            <a href="testimonials.php?edit=<?php echo $t['id']; ?>" class="admin-btn admin-btn-small admin-btn-secondary">Edit</a>
                                            <a href="testimonials.php?action=delete&id=<?php echo $t['id']; ?>" class="admin-btn admin-btn-danger" onclick="return confirm('Delete this review permanently?');">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Form Panel (Add / Edit) -->
        <div class="admin-card">
            <h3><?php echo $edit_mode ? "Edit Testimonial" : "Add New Testimonial"; ?></h3>
            
            <form action="testimonials.php<?php echo $edit_mode ? '?edit=' . $edit_id : ''; ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                
                <div class="admin-form-group">
                    <label for="client_name">Client Name *</label>
                    <input type="text" id="client_name" name="client_name" class="admin-form-control" placeholder="e.g. John Doe" value="<?php echo htmlspecialchars($client_name); ?>" required>
                </div>
                
                <div class="admin-form-group">
                    <label for="role_or_title">Client Subtitle / Role</label>
                    <input type="text" id="role_or_title" name="role_or_title" class="admin-form-control" placeholder="e.g. Musician, Yoga Teacher" value="<?php echo htmlspecialchars($role_or_title); ?>">
                </div>
                
                <div class="admin-form-group">
                    <label for="star_rating">Rating (1 to 5 Stars) *</label>
                    <select id="star_rating" name="star_rating" class="admin-form-control">
                        <option value="5" <?php echo ($star_rating == 5) ? 'selected' : ''; ?>>5 Stars</option>
                        <option value="4" <?php echo ($star_rating == 4) ? 'selected' : ''; ?>>4 Stars</option>
                        <option value="3" <?php echo ($star_rating == 3) ? 'selected' : ''; ?>>3 Stars</option>
                        <option value="2" <?php echo ($star_rating == 2) ? 'selected' : ''; ?>>2 Stars</option>
                        <option value="1" <?php echo ($star_rating == 1) ? 'selected' : ''; ?>>1 Star</option>
                    </select>
                </div>
                
                <div class="admin-form-group">
                    <label for="testimonial_text">Testimonial Body *</label>
                    <textarea id="testimonial_text" name="testimonial_text" class="admin-form-control" rows="5" placeholder="What was their journey with you?" required><?php echo htmlspecialchars($testimonial_text); ?></textarea>
                </div>
                
                <div class="admin-form-group">
                    <label for="video_url">Video Review Link (Optional YouTube Link)</label>
                    <input type="url" id="video_url" name="video_url" class="admin-form-control" placeholder="e.g. https://www.youtube.com/watch?v=..." value="<?php echo htmlspecialchars($video_url); ?>">
                </div>
                
                <div class="admin-form-group" style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" <?php echo ($is_featured == 1) ? 'checked' : ''; ?> style="width: 18px; height: 18px; cursor: pointer;">
                    <label for="is_featured" style="margin: 0; cursor: pointer;">Feature on homepage slider</label>
                </div>
                
                <button type="submit" class="admin-btn" style="width: 100%; margin-top: 15px;">
                    <?php echo $edit_mode ? "Update Testimonial" : "Save Testimonial"; ?>
                </button>
                
                <?php if ($edit_mode): ?>
                    <a href="testimonials.php" class="admin-btn admin-btn-secondary" style="width: 100%; text-align: center; margin-top: 10px; display: block;">Cancel Edit</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
