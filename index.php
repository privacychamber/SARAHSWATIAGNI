<?php
/**
 * Sarah Agni Website - Homepage
 */
$page_title = "Transform Your Hair. Heal Your Energy. Ignite Your Spirit.";
$page_description = "Discover the unique integration of luxury dreadlock artistry and holistic spiritual therapies with Sarah Agni, India's premier dreadlocks specialist and mentor.";
require_once 'includes/header.php';
?>

<!-- Cinematic Hero Section -->
<section class="hero">
    <!-- Ambient Canvas Particles representing fire/breath -->
    <div class="particle-container">
        <canvas id="particleCanvas" class="particle-canvas"></canvas>
    </div>
    
    <!-- Hero Background Image (lazy loaded placeholder or generated image) -->
    <img src="assets/images/hero_dreadlocks.png" alt="Sarah Agni Dreadlock Artistry" class="hero-bg-image">
    
    <div class="container">
        <div class="hero-content reveal-in active">
            <span class="hero-subtitle">Sarah Agni</span>
            <h1 class="hero-title"><?php echo sanitize_input(get_content('home_hero_title', 'Transform Your Hair. Heal Your Energy. Ignite Your Spirit.')); ?></h1>
            <p class="hero-description"><?php echo sanitize_input(get_content('home_hero_subtitle', 'Professional Dreadlocks Artist, Hypnotherapist, Breathwork Guide & Fire Dance Instructor.')); ?></p>
            
            <div class="btn-group">
                <a href="dreadlocks.php" class="btn btn-primary">Book Dreadlocks Session</a>
                <a href="https://wa.me/919999999999" class="btn btn-whatsapp" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i> WhatsApp Sarah</a>
            </div>
            
            <!-- Social Proof Strip -->
            <div class="social-proof-strip">
                <div class="proof-item">
                    <h4>10+</h4>
                    <p>Years Experience</p>
                </div>
                <div class="proof-item">
                    <h4>800+</h4>
                    <p>Dreadlocks Created</p>
                </div>
                <div class="proof-item">
                    <h4>150+</h4>
                    <p>Healed Clients</p>
                </div>
                <div class="proof-item">
                    <h4>50+</h4>
                    <p>Workshops Guided</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Introduction & Core Brand Focus (Dreadlocks) -->
<section class="section-padding reveal-in">
    <div class="container">
        <div class="split-layout">
            <div class="split-image-container">
                <img src="assets/images/sarah_profile.png" alt="Sarah Agni Brand Portrait" class="split-image">
            </div>
            <div class="split-text">
                <span class="text-gold italic-serif" style="font-size: 1.4rem; display: block; margin-bottom: 0.5rem;">The Signature Artistry</span>
                <h2>Master Dreadlock Artist & Repair Specialist</h2>
                <p class="lead-text">
                    "Dreadlocks are not just a hairstyle; they are a crown of strength, patience, and identity. Each lock is sculpted with intention, precision, and respect for your hair's unique pattern."
                </p>
                <p>
                    <?php echo sanitize_input(get_content('home_about_summary', 'Sarah Agni is a visionary dreadlock artist and spiritual facilitator. Combining a decade of dreadlock artistry with transformational healing modalities, she guides individuals through physical, energetic, and creative rebirths.')); ?>
                </p>
                <p>
                    Whether you are starting a new set from scratch, requiring expert repair for thinning roots, or wanting premium human hair extensions, Sarah uses specialized, completely natural, needle-only techniques—never using waxes, chemicals, or adhesives.
                </p>
                <div style="margin-top: 2rem;">
                    <a href="dreadlocks.php" class="btn btn-outline">Explore Dreadlocks Services</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The Holistic Synergy (Secondary Services Overview) -->
<section class="section-padding" style="background-color: #121212;">
    <div class="container">
        <h2 class="section-title reveal-in">The Path of Holistic Transformation</h2>
        <p class="section-subtitle reveal-in">Secondary Services for Energetic Alignment</p>
        
        <div class="services-grid">
            <!-- Healing & Hypnotherapy -->
            <div class="service-card reveal-in">
                <span class="service-icon"><i class="fas fa-magic"></i></span>
                <h3>Hypnotherapy & Healing</h3>
                <p>
                    Access the subconscious mind to release deep-seated trauma, conquer anxiety, and restructure emotional blocks using integrated, gentle clinical hypnotherapy methods.
                </p>
                <a href="healing.php" class="service-link">Learn More <i class="fas fa-chevron-right"></i></a>
            </div>
            
            <!-- Rebirth Breathwork -->
            <div class="service-card reveal-in" style="transition-delay: 0.1s;">
                <span class="service-icon"><i class="fas fa-wind"></i></span>
                <h3>Rebirth Breathwork</h3>
                <p>
                    A powerful conscious circular breathing technique designed to release physical tension, integrate emotional blockages, and promote spiritual clarity.
                </p>
                <a href="breathwork.php" class="service-link">Learn More <i class="fas fa-chevron-right"></i></a>
            </div>
            
            <!-- Fire Dance Training -->
            <div class="service-card reveal-in" style="transition-delay: 0.2s;">
                <span class="service-icon"><i class="fas fa-fire"></i></span>
                <h3>Fire Dance & Movement</h3>
                <p>
                    Connect with the element of fire. Workshops and private classes covering staff and poi, focus choreography, and structural performance safety guidelines.
                </p>
                <a href="fire-dance.php" class="service-link">Learn More <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Work (Gallery Sneak-Peek) -->
<section class="section-padding reveal-in">
    <div class="container">
        <h2 class="section-title">Visual Showcase</h2>
        <p class="section-subtitle">A glimpse of the artistry and energy</p>
        
        <div class="gallery-grid">
            <?php
            // Pull a sample of 4 items across categories to showcase on home page
            $home_gallery = get_gallery_items();
            $display_count = 0;
            if (!empty($home_gallery)) {
                foreach ($home_gallery as $item) {
                    if ($display_count >= 4) break;
                    ?>
                    <div class="gallery-item" 
                         data-category="<?php echo htmlspecialchars($item['category']); ?>"
                         data-src="<?php echo htmlspecialchars($item['image_path']); ?>"
                         data-title="<?php echo htmlspecialchars($item['title']); ?>">
                        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy">
                        <div class="gallery-overlay">
                            <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                            <span><?php echo htmlspecialchars($item['category']); ?></span>
                        </div>
                    </div>
                    <?php
                    $display_count++;
                }
            }
            // If gallery is empty, supply static premium fallbacks so the page isn't blank
            if ($display_count === 0) {
                $placeholders = [
                    ['title' => 'Master Dreadlock Installs', 'cat' => 'dreadlocks', 'img' => 'assets/images/hero_dreadlocks.png'],
                    ['title' => 'Energy Resonance Sessions', 'cat' => 'healing', 'img' => 'assets/images/breathwork_healing.png'],
                    ['title' => 'Sacred Fire Flow', 'cat' => 'firedance', 'img' => 'assets/images/firedance_performance.png'],
                    ['title' => 'Brand Story Roots', 'cat' => 'events', 'img' => 'assets/images/sarah_profile.png'],
                ];
                foreach ($placeholders as $ph) {
                    ?>
                    <div class="gallery-item" 
                         data-category="<?php echo $ph['cat']; ?>"
                         data-src="<?php echo $ph['img']; ?>"
                         data-title="<?php echo $ph['title']; ?>">
                        <img src="<?php echo $ph['img']; ?>" alt="<?php echo $ph['title']; ?>" loading="lazy">
                        <div class="gallery-overlay">
                            <h4><?php echo $ph['title']; ?></h4>
                            <span><?php echo $ph['cat']; ?></span>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        
        <div style="text-align: center; margin-top: 3rem;">
            <a href="gallery.php" class="btn btn-outline">View Full Filterable Gallery</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section-padding testimonials-section reveal-in">
    <div class="container">
        <h2 class="section-title">Client Journeys</h2>
        <p class="section-subtitle">Real experiences of locks & transformation</p>
        
        <div class="testimonial-carousel-container">
            <div class="testimonial-track-container">
                <div class="testimonial-track">
                    <?php
                    $featured_testimonials = get_testimonials(null, true);
                    if (!empty($featured_testimonials)) {
                        foreach ($featured_testimonials as $t) {
                            ?>
                            <div class="testimonial-slide">
                                <div class="testimonial-stars">
                                    <?php for($i = 0; $i < $t['star_rating']; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <blockquote class="testimonial-text">
                                    "<?php echo sanitize_input($t['testimonial_text']); ?>"
                                </blockquote>
                                <div class="testimonial-author"><?php echo sanitize_input($t['client_name']); ?></div>
                                <div class="testimonial-role"><?php echo sanitize_input($t['role_or_title']); ?></div>
                                <?php if (!empty($t['video_url'])): ?>
                                    <br>
                                    <a href="<?php echo htmlspecialchars($t['video_url']); ?>" target="_blank" rel="noopener" class="testimonial-video-btn">
                                        <i class="fab fa-youtube"></i> Watch Video Review
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    } else {
                        // Safe defaults
                        ?>
                        <div class="testimonial-slide">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <blockquote class="testimonial-text">
                                "Sarah is a true artist. My dreads were thinning and heavily damaged. Her repair session was like magic—they look thick, clean, and healthy again. Plus, her space has an amazing healing energy!"
                            </blockquote>
                            <div class="testimonial-author">Aravind Sharma</div>
                            <div class="testimonial-role">Musician & Traveler</div>
                        </div>
                        <div class="testimonial-slide">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <blockquote class="testimonial-text">
                                "The breathwork and healing sessions with Sarah changed my life. I went in to support my anxiety and felt a profound release of old trauma I'd carried for years."
                            </blockquote>
                            <div class="testimonial-author">Maya Fernandes</div>
                            <div class="testimonial-role">Yoga Instructor</div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            
            <!-- Controls -->
            <button class="carousel-nav-btn carousel-prev-btn" aria-label="Previous Slide"><i class="fas fa-chevron-left"></i></button>
            <button class="carousel-nav-btn carousel-next-btn" aria-label="Next Slide"><i class="fas fa-chevron-right"></i></button>
            
            <div class="carousel-dot-container"></div>
        </div>
    </div>
</section>

<!-- Call To Action Panel -->
<section class="section-padding" style="background-color: #080808; border-top: 1px solid rgba(182, 124, 61, 0.1);">
    <div class="container reveal-in">
        <div style="max-width: 700px; margin: 0 auto; text-align: center;">
            <span class="text-gold italic-serif" style="font-size: 1.5rem; display: block; margin-bottom: 1rem;">Are you ready to ignite your transformation?</span>
            <h2 style="font-size: 3rem; margin-bottom: 1.5rem;">Sculpt Your Crowns & Open Your Energy Paths</h2>
            <p style="margin-bottom: 2.5rem;">
                Whether you need expert dreadlocks maintenance or want to experience deep breathwork, Sarah offers customized private sessions tailored to your physical and energetic requirements.
            </p>
            <div class="btn-group">
                <a href="contact.php" class="btn btn-primary">Book Consultation</a>
                <a href="https://wa.me/919999999999" class="btn btn-whatsapp" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
