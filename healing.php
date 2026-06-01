<?php
/**
 * Sarah Agni Website - Healing & Hypnotherapy
 */
$page_title = "Hypnotherapy, Trauma Release & Emotional Healing";
$page_description = "Unlock subconscious pathways to resolve stress, release emotional tension, and restore grounding with Sarah Agni's professional, certified hypnotherapy sittings.";
require_once 'includes/header.php';
?>

<!-- Healing Header -->
<section class="section-padding" style="padding-top: 150px; background: linear-gradient(180deg, #121212 0%, var(--color-bg-dark) 100%);">
    <div class="container">
        <!-- Safety Disclaimer Callout at Top -->
        <div style="background-color: rgba(182, 124, 61, 0.05); border: 1px solid rgba(182, 124, 61, 0.2); padding: 15px 25px; margin-bottom: 40px; text-align: center; border-radius: 4px;">
            <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-gold); margin: 0;">
                <i class="fas fa-info-circle"></i> Holistic Wellness Care: The following services support emotional self-regulation and personal growth. They are not medical treatments.
            </p>
        </div>

        <h1 class="section-title reveal-in">Hypnotherapy & Emotional Healing</h1>
        <p class="section-subtitle reveal-in">Somatic Re-alignment & Subconscious Release</p>
        
        <div class="split-layout" style="margin-top: 40px; align-items: center;">
            <div class="split-image-container reveal-in">
                <img src="assets/images/breathwork_healing.png" alt="Somatic Healing Session Room" class="split-image">
            </div>
            
            <div class="split-text reveal-in" style="transition-delay: 0.15s;">
                <span class="text-gold italic-serif" style="font-size: 1.4rem; display: block; margin-bottom: 0.5rem;">The Inner Dialogue</span>
                <h2>What is Spiritual & Subconscious Healing?</h2>
                <p class="lead-text">
                    "We do not struggle because we are weak. We struggle because our subconscious mind is still running old survival scripts that no longer serve us."
                </p>
                <p>
                    <?php echo sanitize_input(get_content('healing_intro_text', 'A gentle, integrated path of clinical hypnotherapy, trauma release, and emotional alignment. Designed to guide you from stress and anxiety into deep center-grounding and energetic clarity.')); ?>
                </p>
                <p>
                    During a session, Sarah guides you into a deep state of somatic relaxation. By calming the critical analytical mind, we gain direct access to the subconscious space. Here, we can identify past events, clarify childhood programming, and release physical imprints of stress safely.
                </p>
                <div style="margin-top: 2rem;">
                    <a href="contact.php?interest=healing" class="btn btn-primary">Book Private Session</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Healing Services Grid -->
<section class="section-padding" style="background-color: #0d0d0d; border-top: 1px solid rgba(182, 124, 61, 0.1); border-bottom: 1px solid rgba(182, 124, 61, 0.1);">
    <div class="container">
        <h2 class="section-title reveal-in">Modalities & Support Areas</h2>
        <p class="section-subtitle reveal-in">Gentle, safe, and professional guidance</p>
        
        <div class="services-grid">
            <!-- Hypnotherapy -->
            <div class="service-card reveal-in">
                <span class="service-icon"><i class="fas fa-brain"></i></span>
                <h3>Subconscious Reprogramming</h3>
                <p>
                    Cleanse limiting beliefs and negative behavioral loops. By using gentle suggestion and regression techniques, we align your subconscious thoughts with your conscious goals.
                </p>
            </div>
            
            <!-- Trauma Release -->
            <div class="service-card reveal-in" style="transition-delay: 0.05s;">
                <span class="service-icon"><i class="fas fa-heart-broken"></i></span>
                <h3>Somatic Trauma Release</h3>
                <p>
                    Trauma is often held physically as chronic muscle contraction or nervous system stress. We use breathing and grounding patterns to release physical imprints of trauma.
                </p>
            </div>
            
            <!-- Anxiety Support -->
            <div class="service-card reveal-in" style="transition-delay: 0.1s;">
                <span class="service-icon"><i class="fas fa-shield-alt"></i></span>
                <h3>Anxiety & Stress Regulation</h3>
                <p>
                    Calm a hyperactive nervous system. Learn practical vagus nerve stimulation exercises and auto-hypnosis keywords to manage stress immediately.
                </p>
            </div>
            
            <!-- Emotional Healing -->
            <div class="service-card reveal-in" style="transition-delay: 0.15s;">
                <span class="service-icon"><i class="fas fa-hand-holding-heart"></i></span>
                <h3>Grief & Loss Integration</h3>
                <p>
                    A compassionate, quiet container to process grief, divorce, major life transitions, and restore a sense of inner safety and emotional balance.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Our Approach & Philosophy -->
<section class="section-padding">
    <div class="container">
        <div class="split-layout" style="direction: rtl;">
            <div class="split-image-container reveal-in" style="direction: ltr;">
                <img src="assets/images/sarah_profile.png" alt="Sarah Spiritual Mentor" class="split-image">
            </div>
            
            <div class="split-text reveal-in" style="direction: ltr; transition-delay: 0.15s;">
                <span class="text-gold italic-serif" style="font-size: 1.4rem; display: block; margin-bottom: 0.5rem;">Core Ideals</span>
                <h2>A Safe, Professional Healing Space</h2>
                <p>
                    Every healing session is structured with strict ethical standards. Sarah does not make medical or diagnostic claims, nor does she prescribe treatments. Instead, she facilitates self-healing by helping you regulate your nervous system.
                </p>
                <p>
                    Sessions are conducted in-person at her quiet wellness studio or online via secure video calls. Prior to booking, you will receive a disclosure form outlining the structure of the session to ensure clarity, safety, and mutual alignment.
                </p>
                
                <div class="disclaimer-card" style="margin-top: 2rem; text-align: left;">
                    <h4>Professional Disclaimer</h4>
                    <p style="font-size: 0.8rem; margin: 0; line-height: 1.6;">
                        Sarah Agni is a certified clinical hypnotherapist and holistic guide, not a licensed psychiatrist, medical doctor, or clinical psychologist. Hypnotherapy and somatic therapies are support tools and must not be used to replace diagnosed clinical psychiatric therapy or medical interventions.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
