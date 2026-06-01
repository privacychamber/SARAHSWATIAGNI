<?php
/**
 * Sarah Agni Website - Fire Dance Training
 */
$page_title = "Fire Dance Classes, Workshops & Performances";
$page_description = "Learn the art of flow. Professional fire dance classes, safety training, staff/poi workshops, and premium event performance bookings in Goa and globally.";
require_once 'includes/header.php';
?>

<!-- Fire Dance Header -->
<section class="section-padding" style="padding-top: 150px; background: linear-gradient(180deg, #180a02 0%, var(--color-bg-dark) 100%);">
    <div class="container">
        <!-- Safety Alert -->
        <div style="background-color: rgba(255, 138, 0, 0.05); border: 1px solid rgba(255, 138, 0, 0.2); padding: 15px 25px; margin-bottom: 40px; text-align: center; border-radius: 4px;">
            <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-amber); margin: 0;">
                <i class="fas fa-fire-extinguisher"></i> Safety First: All live fire training sessions require certified safety gear, fire retardant clothes, and fuel safety equipment.
            </p>
        </div>

        <h1 class="section-title reveal-in" style="text-shadow: 0 0 20px rgba(255, 138, 0, 0.3);">Fire Dance & Movement</h1>
        <p class="section-subtitle reveal-in" style="color: var(--color-amber);">The Art of Flow, Presence & Fire Safety</p>
        
        <div class="split-layout" style="margin-top: 40px; align-items: center;">
            <div class="split-image-container reveal-in">
                <img src="assets/images/firedance_performance.png" alt="Sarah Fire Dance Performance" class="split-image">
            </div>
            
            <div class="split-text reveal-in" style="transition-delay: 0.15s;">
                <span class="text-amber italic-serif" style="font-size: 1.4rem; display: block; margin-bottom: 0.5rem;">The Flow State</span>
                <h2>Dancing with the Element of Fire</h2>
                <p class="lead-text" style="color: #ffd8b3;">
                    "Fire does not negotiate. It forces you to quiet your mind, master your breath, and exist fully in your physical body."
                </p>
                <p>
                    <?php echo sanitize_input(get_content('firedance_intro_text', 'Ignite your internal flame. Fire dance is more than movement; it is a spiritual dialogue with energy, fear, and focus. Weekly classes range from beginner poi/staff to intermediate safety choreography.')); ?>
                </p>
                <p>
                    Through structured training, Sarah breaks down complex flow coordinates into clear steps. Her classes are designed to help you build coordination, confidence, and respect for fire. She prioritizes safety, teaching prop management and fire safety procedures alongside movement choreography.
                </p>
                <div style="margin-top: 2rem;">
                    <a href="contact.php?interest=firedance" class="btn btn-primary btn-primary:hover" style="background: linear-gradient(135deg, #a65000 0%, #612200 100%); border-color: var(--color-amber); box-shadow: var(--shadow-amber-glow);">Book Training Session</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Classes & Workshops Grid -->
<section class="section-padding" style="background-color: #0d0d0d; border-top: 1px solid rgba(255, 138, 0, 0.1); border-bottom: 1px solid rgba(255, 138, 0, 0.1);">
    <div class="container">
        <h2 class="section-title reveal-in">Training & Performance Options</h2>
        <p class="section-subtitle reveal-in" style="color: var(--color-amber);">Prop choices: Single Staff, Double Staff, and Poi</p>
        
        <div class="services-grid">
            <!-- Beginner Classes -->
            <div class="service-card reveal-in" style="border-color: rgba(255, 138, 0, 0.15);">
                <span class="service-icon" style="color: var(--color-amber);"><i class="fas fa-seedling"></i></span>
                <h3>Beginner Flow</h3>
                <p>
                    No experience required. We start with unlit practice props, learning basic spin paths, wrist wraps, and body turns to build clean muscle memory.
                </p>
            </div>
            
            <!-- Intermediate Classes -->
            <div class="service-card reveal-in" style="transition-delay: 0.05s; border-color: rgba(255, 138, 0, 0.15);">
                <span class="service-icon" style="color: var(--color-amber);"><i class="fas fa-meteor"></i></span>
                <h3>Intermediate & Live Fire</h3>
                <p>
                    Transition to live fire spinning. Learn essential fuel safety, spinning techniques, fire safety protocols, and simple movement choreography.
                </p>
            </div>
            
            <!-- Event Performances -->
            <div class="service-card reveal-in" style="transition-delay: 0.1s; border-color: rgba(255, 138, 0, 0.15);">
                <span class="service-icon" style="color: var(--color-amber);"><i class="fas fa-bolt"></i></span>
                <h3>Event Performances</h3>
                <p>
                    High-energy, dramatic live fire shows for retreats, festivals, weddings, and private events. Shows are fully safety-insured with dedicated support crews.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Safety Guidelines -->
<section class="section-padding">
    <div class="container">
        <div class="split-layout" style="direction: rtl;">
            <div class="split-image-container reveal-in" style="direction: ltr;">
                <img src="assets/images/hero_dreadlocks.png" alt="Safety Briefing Setup" class="split-image" style="filter: sepia(40%) hue-rotate(-20deg) brightness(85%);">
            </div>
            
            <div class="split-text reveal-in" style="direction: ltr; transition-delay: 0.15s;">
                <span class="text-amber italic-serif" style="font-size: 1.4rem; display: block; margin-bottom: 0.5rem;">Flow Protocol</span>
                <h2>Safety & Preparation Standards</h2>
                <p>
                    Safety is at the core of fire spinning. Before lighting any prop, every student learns:
                </p>
                
                <ul class="pricing-features" style="margin-top: 1.5rem; padding-left: 20px;">
                    <li style="color: var(--color-cream);"><strong style="color: var(--color-amber);">Retardant Clothing:</strong> Using natural fibers (cotton, denim, leather) that do not melt like synthetic fabrics.</li>
                    <li style="color: var(--color-cream);"><strong style="color: var(--color-amber);">Fuel Protocols:</strong> Safe fueling procedures using closed containers, spin-off boxes, and kerosene fuels.</li>
                    <li style="color: var(--color-cream);"><strong style="color: var(--color-amber);">Dampening blanket:</strong> Proper use of wet cotton duvet dampening blankets to extinguish props.</li>
                    <li style="color: var(--color-cream);"><strong style="color: var(--color-amber);">Nervous Regulation:</strong> Keeping a calm, steady heart rate to avoid erratic movement while spinning.</li>
                </ul>
                
                <div style="margin-top: 2rem;">
                    <a href="gallery.php?category=firedance" class="btn btn-outline" style="border-color: var(--color-amber);">View Fire Dance Gallery</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
