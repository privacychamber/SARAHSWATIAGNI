<?php
/**
 * Sarah Agni Website - Rebirth Breathwork
 */
$page_title = "Rebirth Breathwork Sessions & Ceremonies";
$page_description = "Experience Rebirth Breathwork - a conscious circular breathing method that promotes somatic release, deep relaxation, and mental clarity under professional guidance.";
require_once 'includes/header.php';
?>

<!-- Breathwork Hero Section -->
<section class="section-padding" style="padding-top: 150px; background: linear-gradient(180deg, #121212 0%, var(--color-bg-dark) 100%);">
    <div class="container">
        <!-- Safety Alert -->
        <div style="background-color: rgba(182, 124, 61, 0.05); border: 1px solid rgba(182, 124, 61, 0.2); padding: 15px 25px; margin-bottom: 40px; text-align: center; border-radius: 4px;">
            <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-gold); margin: 0;">
                <i class="fas fa-exclamation-triangle"></i> Important Contraindications: Breathwork is not suitable for individuals with cardiovascular disease, severe hypertension, glaucoma, epilepsy, or active pregnancy.
            </p>
        </div>

        <h1 class="section-title reveal-in">Rebirth Breathwork</h1>
        <p class="section-subtitle reveal-in">Conscious Circular Breathing for Somatic Integration</p>
        
        <div class="split-layout" style="margin-top: 40px; align-items: center;">
            <div class="split-text reveal-in">
                <span class="text-gold italic-serif" style="font-size: 1.4rem; display: block; margin-bottom: 0.5rem;">The Power of Breath</span>
                <h2>What is Rebirth Breathwork?</h2>
                <p class="lead-text">
                    "Breath is the bridge between the conscious and subconscious. By altering the pattern of our breathing, we change our internal biochemistry and release deep stress."
                </p>
                <p>
                    <?php echo sanitize_input(get_content('breathwork_intro_text', 'Rebirth Breathwork is a circular breathing method that facilitates somatic release, emotional integration, and altered states of consciousness, allowing deep-seated blockages to dissolve naturally.')); ?>
                </p>
                <p>
                    Unlike standard meditative breathing, Rebirth Breathwork utilizes a continuous, circular pattern (no pauses between inhalation and exhalation). This floods the body with oxygen and temporarily lowers carbon dioxide levels, shifting the brain into a state of active neuro-integration. 
                </p>
                <p>
                    This process often activates the parasympathetic nervous system, allowing deep emotional blocks, physical tension, and old stress memories to surface and dissolve in a safe, controlled setting.
                </p>
                <div style="margin-top: 2rem;">
                    <a href="contact.php?interest=breathwork" class="btn btn-primary">Book Breathwork Session</a>
                </div>
            </div>
            
            <div class="split-image-container reveal-in" style="transition-delay: 0.15s;">
                <img src="assets/images/breathwork_healing.png" alt="Rebirth Breathwork Space" class="split-image">
            </div>
        </div>
    </div>
</section>

<!-- Physiological & Somatic Benefits -->
<section class="section-padding" style="background-color: #0d0d0d; border-top: 1px solid rgba(182, 124, 61, 0.1); border-bottom: 1px solid rgba(182, 124, 61, 0.1);">
    <div class="container">
        <h2 class="section-title reveal-in">The Benefits of Conscious Breathing</h2>
        <p class="section-subtitle reveal-in">Backed by somatic and respiratory mechanics</p>
        
        <div class="services-grid">
            <!-- Benefit 1 -->
            <div class="service-card reveal-in">
                <span class="service-icon"><i class="fas fa-heartbeat"></i></span>
                <h3>Nervous System Regulation</h3>
                <p>
                    Circular breathing helps stimulate the vagus nerve after the active phase. This lowers your baseline heart rate, reduces cortisol production, and strengthens your stress response.
                </p>
            </div>
            
            <!-- Benefit 2 -->
            <div class="service-card reveal-in" style="transition-delay: 0.05s;">
                <span class="service-icon"><i class="fas fa-spa"></i></span>
                <h3>Somatic Stress Release</h3>
                <p>
                    The body holds memories of chronic stress as muscle tension. The active phase of breathwork helps identify and release these localized physical blockages.
                </p>
            </div>
            
            <!-- Benefit 3 -->
            <div class="service-card reveal-in" style="transition-delay: 0.1s;">
                <span class="service-icon"><i class="fas fa-lightbulb"></i></span>
                <h3>Mental Clarity & Focus</h3>
                <p>
                    By quieting the default mode network (DMN) in the brain, circular breathing helps reduce circular negative thoughts, providing clarity and deep emotional insights.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- The Session Experience -->
<section class="section-padding">
    <div class="container">
        <h2 class="section-title reveal-in">The Session Experience</h2>
        <p class="section-subtitle reveal-in">A three-phase journey of release</p>
        
        <div class="timeline">
            <!-- Phase 1 -->
            <div class="timeline-item timeline-left reveal-in">
                <div class="timeline-badge">01</div>
                <div class="timeline-content">
                    <h3>Preparation & Intake (20 mins)</h3>
                    <p>We discuss your physical health and set a clear focus. We review the circular breathing pattern and detail standard physical sensations like tingling or temperature changes.</p>
                </div>
            </div>
            
            <!-- Phase 2 -->
            <div class="timeline-item timeline-right reveal-in" style="transition-delay: 0.1s;">
                <div class="timeline-badge">02</div>
                <div class="timeline-content">
                    <h3>The Active Breath (50 mins)</h3>
                    <p>Lying down comfortably, you begin the continuous, circular breath. Sarah monitors your pace, holds space, and uses grounding touch (with consent) to support your process.</p>
                </div>
            </div>
            
            <!-- Phase 3 -->
            <div class="timeline-item timeline-left reveal-in" style="transition-delay: 0.2s;">
                <div class="timeline-badge">03</div>
                <div class="timeline-content">
                    <h3>Integration & Grounding (20 mins)</h3>
                    <p>The breathing slows down to a normal pace. You rest in deep quietness. We conclude with gentle grounding, journaling, and a hot cup of tea to process insights.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Breathwork FAQs -->
<section class="section-padding" style="background-color: #101010; border-top: 1px solid rgba(182, 124, 61, 0.1);">
    <div class="container">
        <h2 class="section-title reveal-in">Breathwork FAQs</h2>
        <p class="section-subtitle reveal-in">Answers to common questions about circular breathing</p>
        
        <div class="faq-accordion reveal-in">
            <div class="faq-item">
                <button class="faq-header">
                    What does a session feel like physically?
                    <span class="faq-icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-content">
                    <p>As oxygen levels increase, you may feel tingling in your hands and feet, slight temperature shifts, or a temporary tightening of the hands (tetany). These are completely natural, harmless physiological responses that resolve quickly once the breathing pattern slows down.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-header">
                    How is Rebirth Breathwork different from pranayama?
                    <span class="faq-icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-content">
                    <p>Pranayama involves structured controls and pauses to manage energy flow. Rebirth Breathwork uses a continuous, circular pattern without pauses. This specific loop is designed for somatic release and emotional processing rather than mental centering.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-header">
                    Is it safe to do online?
                    <span class="faq-icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-content">
                    <p>Yes. Private online sessions are conducted via video with strict setup rules to ensure safety. You must have a quiet space to lie down, and your camera must show your upper body so Sarah can monitor your breathing rate throughout the session.</p>
                </div>
            </div>
        </div>
        
        <div class="disclaimer-card" style="margin-top: 40px;">
            <h4>Medical Disclaimer</h4>
            <p>
                Rebirth Breathwork is a powerful physical experience and is not a substitute for clinical psychiatric care. It is contraindicated for individuals with a history of cardiovascular issues, severe asthma, psychiatric hospitalization, glaucoma, or aneurysm. Consult your physician before booking if you have any underlying health concerns.
            </p>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
