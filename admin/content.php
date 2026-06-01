<?php
/**
 * Admin Panel Content Key-Value Editor
 */
require_once __DIR__ . '/header.php';

$success = "";
$error = "";

$content_fields = [
    'home_hero_title' => 'Home Hero Headline',
    'home_hero_subtitle' => 'Home Hero Subtitle',
    'home_about_summary' => 'Home About Profile Summary',
    'dreadlocks_pricing_new' => 'Dreadlocks: New Installs Price Details',
    'dreadlocks_pricing_maint' => 'Dreadlocks: Maintenance Price Details',
    'dreadlocks_pricing_extensions' => 'Dreadlocks: Extensions & Repairs Price Details',
    'healing_intro_text' => 'Healing Page Introduction Text',
    'breathwork_intro_text' => 'Breathwork Page Introduction Text',
    'firedance_intro_text' => 'Fire Dance Page Introduction Text'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    
    if (!verify_csrf_token($csrf_token)) {
        $error = "CSRF verification failed. Try again.";
    } else {
        try {
            $updated_count = 0;
            foreach ($content_fields as $key => $label) {
                if (isset($_POST[$key])) {
                    $val = sanitize_input($_POST[$key]);
                    update_content($key, $val);
                    $updated_count++;
                }
            }
            $success = "Successfully updated $updated_count content sections on the live website.";
        } catch (PDOException $e) {
            $error = "Failed to update content: " . $e->getMessage();
        }
    }
}

$token = generate_csrf_token();
?>

<div class="admin-container">
    <div class="admin-header-row">
        <h2>Edit Page Content & Pricing</h2>
    </div>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="admin-card">
        <h3>Site-Wide Content Editor</h3>
        <p style="color: var(--color-admin-muted); margin-bottom: 20px; font-size: 0.9rem;">
            Modify the copy and price descriptions on the public site below. Leave fields empty if you wish to reset or display empty, but we advise filling all blocks.
        </p>
        
        <form action="content.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Column 1: Home and Healing -->
                <div>
                    <h4 style="color: var(--color-admin-gold); font-size: 1.1rem; border-bottom: 1px solid var(--color-admin-border); padding-bottom: 8px; margin-bottom: 20px;">Home Page & Core Narrative</h4>
                    
                    <div class="admin-form-group">
                        <label for="home_hero_title">Home Hero Headline</label>
                        <input type="text" id="home_hero_title" name="home_hero_title" class="admin-form-control" 
                               value="<?php echo htmlspecialchars(get_content('home_hero_title')); ?>" required>
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="home_hero_subtitle">Home Hero Sub-headline</label>
                        <textarea id="home_hero_subtitle" name="home_hero_subtitle" class="admin-form-control" rows="3" required><?php echo htmlspecialchars(get_content('home_hero_subtitle')); ?></textarea>
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="home_about_summary">Home About Section Summary</label>
                        <textarea id="home_about_summary" name="home_about_summary" class="admin-form-control" rows="4" required><?php echo htmlspecialchars(get_content('home_about_summary')); ?></textarea>
                    </div>
                    
                    <h4 style="color: var(--color-admin-gold); font-size: 1.1rem; border-bottom: 1px solid var(--color-admin-border); padding-bottom: 8px; margin-top: 40px; margin-bottom: 20px;">Secondary Modality Introductions</h4>
                    
                    <div class="admin-form-group">
                        <label for="healing_intro_text">Healing & Hypnotherapy Introduction</label>
                        <textarea id="healing_intro_text" name="healing_intro_text" class="admin-form-control" rows="3" required><?php echo htmlspecialchars(get_content('healing_intro_text')); ?></textarea>
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="breathwork_intro_text">Rebirth Breathwork Introduction</label>
                        <textarea id="breathwork_intro_text" name="breathwork_intro_text" class="admin-form-control" rows="3" required><?php echo htmlspecialchars(get_content('breathwork_intro_text')); ?></textarea>
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="firedance_intro_text">Fire Dance Introduction</label>
                        <textarea id="firedance_intro_text" name="firedance_intro_text" class="admin-form-control" rows="3" required><?php echo htmlspecialchars(get_content('firedance_intro_text')); ?></textarea>
                    </div>
                </div>
                
                <!-- Column 2: Dreadlocks Pricing -->
                <div>
                    <h4 style="color: var(--color-admin-gold); font-size: 1.1rem; border-bottom: 1px solid var(--color-admin-border); padding-bottom: 8px; margin-bottom: 20px;">Dreadlocks Pricing Card Details</h4>
                    
                    <div class="admin-form-group">
                        <label for="dreadlocks_pricing_new">New Installations Card Footer Text</label>
                        <textarea id="dreadlocks_pricing_new" name="dreadlocks_pricing_new" class="admin-form-control" rows="4" required><?php echo htmlspecialchars(get_content('dreadlocks_pricing_new')); ?></textarea>
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="dreadlocks_pricing_maint">Maintenance Card Footer Text</label>
                        <textarea id="dreadlocks_pricing_maint" name="dreadlocks_pricing_maint" class="admin-form-control" rows="4" required><?php echo htmlspecialchars(get_content('dreadlocks_pricing_maint')); ?></textarea>
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="dreadlocks_pricing_extensions">Extensions / Repairs Card Footer Text</label>
                        <textarea id="dreadlocks_pricing_extensions" name="dreadlocks_pricing_extensions" class="admin-form-control" rows="4" required><?php echo htmlspecialchars(get_content('dreadlocks_pricing_extensions')); ?></textarea>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="admin-btn" style="width: 100%; margin-top: 30px; padding: 15px;">Save Content Changes</button>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>
