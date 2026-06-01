<?php
/**
 * Sarah Agni Website - Contact & Booking
 */
$page_title = "Connect & Book a Session | Sarah Agni";
$page_description = "Get in touch with Sarah Agni for dreadlocks sculpting, hypnotherapy sessions, rebirth breathwork workshops, or event performances. Location details & secure contact form.";

require_once 'includes/functions.php';

$success_msg = "";
$error_msg = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    
    if (!verify_csrf_token($csrf_token)) {
        $error_msg = "Security validation failed. Please try submitting the form again.";
    } else {
        // Sanitize and read input data
        $name = sanitize_input($_POST['name'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $phone = sanitize_input($_POST['phone'] ?? '');
        $interest = sanitize_input($_POST['service_interest'] ?? '');
        $message = sanitize_input($_POST['message'] ?? '');
        
        if (empty($name) || !$email || empty($message)) {
            $error_msg = "Please fill in all required fields (Name, valid Email, and Message).";
        } else {
            try {
                // Insert request into database
                $stmt = $pdo->prepare("INSERT INTO contact_requests (name, email, phone, service_interest, message) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $phone, $interest, $message]);
                
                $success_msg = "Thank you! Your request has been logged successfully. Sarah will reach out to you shortly.";
                
                // Backup option: Send email notification to Sarah via standard PHP mail
                $to = "sarah@example.com"; // User will update to their administrative address
                $subject = "New Personal Website Inquiry: " . $interest;
                $body = "You have received a new contact request from your brand website.\n\n" .
                        "Name: $name\n" .
                        "Email: $email\n" .
                        "Phone: $phone\n" .
                        "Interest: $interest\n\n" .
                        "Message:\n$message\n\n" .
                        "This message has also been saved to your Admin Panel.";
                $headers = "From: noreply@" . $_SERVER['HTTP_HOST'] . "\r\n" .
                           "Reply-To: $email\r\n" .
                           "X-Mailer: PHP/" . phpversion();
                
                @mail($to, $subject, $body, $headers); // Silenced since mail() might fail on local host setups
                
            } catch (PDOException $e) {
                $error_msg = "A database error occurred. Your message could not be saved. Error: " . $e->getMessage();
            }
        }
    }
}

// Generate new CSRF token for the form
$token = generate_csrf_token();

// Check for pre-selected service in query parameter
$preselected = isset($_GET['interest']) ? sanitize_input($_GET['interest']) : '';

require_once 'includes/header.php';
?>

<!-- Contact Header -->
<section class="section-padding" style="padding-top: 150px; background: linear-gradient(180deg, #121212 0%, var(--color-bg-dark) 100%);">
    <div class="container">
        <h1 class="section-title reveal-in">Connect with Sarah</h1>
        <p class="section-subtitle reveal-in">Schedule a consultation or book your transformational session</p>
        
        <div class="contact-grid reveal-in" style="margin-top: 40px;">
            <!-- Left Panel: Info and socials -->
            <div class="contact-info-panel">
                <h3>Let's Collaborate</h3>
                <p>
                    Whether you are starting a new dreadlocks journey, looking for deep somatic release, or booking a fire flow performance, please reach out. Sarah splits her time between Goa (India), Bali (Indonesia), and global retreat workshops.
                </p>
                
                <div class="contact-details">
                    <div class="contact-detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Location</h4>
                            <p>Arambol, Goa, India (Seasonal Retreat Studio)</p>
                        </div>
                    </div>
                    <div class="contact-detail-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>connect@sarahagni.com</p>
                        </div>
                    </div>
                    <div class="contact-detail-item">
                        <i class="fab fa-whatsapp"></i>
                        <div>
                            <h4>Direct WhatsApp</h4>
                            <p>+91 99999 99999</p>
                        </div>
                    </div>
                </div>
                
                <h4 style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.15em; color: var(--color-gold); margin-bottom: 1rem;">Social Media</h4>
                <div class="social-icons" style="margin-bottom: 2rem;">
                    <a href="https://www.instagram.com/sarah_agni" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/sarah_agni" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.youtube.com/sarah_agni" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
                
                <!-- Quick WhatsApp Booking Hook -->
                <a href="https://wa.me/919999999999?text=Hello%20Sarah,%20I'd%20like%20to%20inquire%20about%20a%20session." class="btn btn-whatsapp" target="_blank" rel="noopener" style="width: 100%; text-align: center;">
                    <i class="fab fa-whatsapp"></i> Quick Book on WhatsApp
                </a>
            </div>
            
            <!-- Right Panel: Safe HTML5/PHP Form -->
            <div class="contact-form-container">
                <h3 style="margin-bottom: 20px; font-family: var(--font-heading); font-size: 1.8rem; color: var(--color-gold);">Send a Message</h3>
                
                <?php if (!empty($success_msg)): ?>
                    <div class="form-alert form-alert-success"><?php echo $success_msg; ?></div>
                <?php endif; ?>
                
                <?php if (!empty($error_msg)): ?>
                    <div class="form-alert form-alert-error"><?php echo $error_msg; ?></div>
                <?php endif; ?>
                
                <form action="contact.php" method="POST" autocomplete="on">
                    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                    
                    <div class="form-group">
                        <label for="name">Your Name *</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. John Doe" required autocomplete="name">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="e.g. john@example.com" required autocomplete="email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="e.g. +91 98765 43210" autocomplete="tel">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="service_interest">Area of Interest</label>
                        <select id="service_interest" name="service_interest" class="form-control">
                            <option value="dreadlocks_new" <?php echo ($preselected === 'dreadlocks_new') ? 'selected' : ''; ?>>New Dreadlocks Installation (Primary Focus)</option>
                            <option value="dreadlocks_maint" <?php echo ($preselected === 'dreadlocks_maint') ? 'selected' : ''; ?>>Dreadlocks Maintenance / Repair</option>
                            <option value="healing" <?php echo ($preselected === 'healing') ? 'selected' : ''; ?>>Hypnotherapy & Healing Session</option>
                            <option value="breathwork" <?php echo ($preselected === 'breathwork') ? 'selected' : ''; ?>>Rebirth Breathwork Seminar</option>
                            <option value="firedance" <?php echo ($preselected === 'firedance') ? 'selected' : ''; ?>>Fire Dance Training / Workshop</option>
                            <option value="other" <?php echo ($preselected === 'other') ? 'selected' : ''; ?>>General / Collaborative Booking</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Your Message *</label>
                        <textarea id="message" name="message" class="form-control" rows="5" placeholder="Share details about your hair length, current locks, or specific healing goals..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Inquire</button>
                </form>
            </div>
        </div>
        
        <!-- Google Maps Embed for SEO local trust (Stylized dark on CSS level) -->
        <div class="map-container reveal-in" style="transition-delay: 0.1s;">
            <iframe 
                title="Sarah Agni Wellness Studio Map Location"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3840.4072236979203!2d73.70295191484196!3d15.698293989110486!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbf797af5555555%3A0x6bba888888888888!2sArambol%20Beach!5e0!3m2!1sen!2sin!4v1655000000000!5m2!1sen!2sin" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
