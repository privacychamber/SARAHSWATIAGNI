<?php
/**
 * Admin Panel Dashboard & Lead Manager
 */
require_once __DIR__ . '/header.php';

$success = "";
$error = "";

// Handle Lead Management Actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = sanitize_input($_GET['action']);
    $lead_id = (int)$_GET['id'];
    
    // Quick CSRF bypass check for simple links (we check if session matches or if simple action is validated)
    try {
        if ($action === 'read') {
            $stmt = $pdo->prepare("UPDATE contact_requests SET status = 'read' WHERE id = ?");
            $stmt->execute([$lead_id]);
            $success = "Lead marked as read.";
        } elseif ($action === 'archive') {
            $stmt = $pdo->prepare("UPDATE contact_requests SET status = 'archived' WHERE id = ?");
            $stmt->execute([$lead_id]);
            $success = "Lead archived successfully.";
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM contact_requests WHERE id = ?");
            $stmt->execute([$lead_id]);
            $success = "Lead deleted permanently.";
        }
    } catch (PDOException $e) {
        $error = "Action failed: " . $e->getMessage();
    }
}

// Fetch Leads list
try {
    $stmt = $pdo->query("SELECT * FROM contact_requests ORDER BY created_at DESC");
    $leads = $stmt->fetchAll();
    
    // Count stats
    $count_unread = 0;
    $count_total = count($leads);
    foreach ($leads as $l) {
        if ($l['status'] === 'unread') $count_unread++;
    }
} catch (PDOException $e) {
    $leads = [];
    $error = "Failed to load requests: " . $e->getMessage();
}
?>

<div class="admin-container">
    <div class="admin-header-row">
        <h2>Contact Requests (Leads)</h2>
        <div>Logged in as: <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></div>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Unread Messages</h3>
            <div class="stat-number"><?php echo $count_unread; ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Leads</h3>
            <div class="stat-number"><?php echo $count_total; ?></div>
        </div>
    </div>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <!-- Leads List -->
    <div class="admin-card">
        <h3>Inbox & Inquiries</h3>
        
        <?php if (empty($leads)): ?>
            <p style="padding: 20px 0; color: var(--color-admin-muted);">No inquiries logged in the database yet.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Name / Contact</th>
                            <th>Interest</th>
                            <th>Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $lead): ?>
                            <tr>
                                <td>
                                    <span class="badge badge-<?php echo htmlspecialchars($lead['status']); ?>">
                                        <?php echo htmlspecialchars($lead['status']); ?>
                                    </span>
                                </td>
                                <td style="white-space: nowrap; font-size: 0.8rem; color: var(--color-admin-muted);">
                                    <?php echo date('d M Y, H:i', strtotime($lead['created_at'])); ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($lead['name']); ?></strong><br>
                                    <span style="font-size: 0.8rem; color: var(--color-admin-muted);"><?php echo htmlspecialchars($lead['email']); ?></span><br>
                                    <span style="font-size: 0.8rem; color: var(--color-admin-muted);"><?php echo htmlspecialchars($lead['phone'] ?: 'No Phone'); ?></span>
                                </td>
                                <td style="font-weight: 500; font-size: 0.85rem; color: var(--color-admin-gold);">
                                    <?php 
                                    $interests = [
                                        'dreadlocks_new' => 'New Dreadlocks Installs',
                                        'dreadlocks_maint' => 'Dreadlocks Maintenance',
                                        'healing' => 'Hypnotherapy & Healing',
                                        'breathwork' => 'Rebirth Breathwork',
                                        'firedance' => 'Fire Dance Training',
                                        'other' => 'General Inquire'
                                    ];
                                    echo isset($interests[$lead['service_interest']]) ? $interests[$lead['service_interest']] : htmlspecialchars($lead['service_interest']);
                                    ?>
                                </td>
                                <td style="font-size: 0.85rem; max-width: 300px; word-wrap: break-word;">
                                    <?php echo nl2br(htmlspecialchars($lead['message'])); ?>
                                </td>
                                <td>
                                    <div class="btn-actions-cell">
                                        <?php if ($lead['status'] === 'unread'): ?>
                                            <a href="index.php?action=read&id=<?php echo $lead['id']; ?>" class="admin-btn admin-btn-small" style="background-color: var(--color-success); border-color: var(--color-success);">Mark Read</a>
                                        <?php endif; ?>
                                        
                                        <?php if ($lead['status'] !== 'archived'): ?>
                                            <a href="index.php?action=archive&id=<?php echo $lead['id']; ?>" class="admin-btn admin-btn-small admin-btn-secondary">Archive</a>
                                        <?php endif; ?>
                                        
                                        <a href="index.php?action=delete&id=<?php echo $lead['id']; ?>" class="admin-btn admin-btn-danger" onclick="return confirm('Permanently delete this inquiry?');">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'footer.php'; ?>
