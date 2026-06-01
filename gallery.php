<?php
/**
 * Sarah Agni Website - Media Gallery
 */
$page_title = "The Media Gallery | Artistry, Fire & Healing";
$page_description = "Browse through the visual gallery of Sarah Agni's high-end dreadlocks installations, live fire dance flow performances, and holistic retreat workshops.";
require_once 'includes/header.php';
?>

<!-- Gallery Header -->
<section class="section-padding" style="padding-top: 150px; background: linear-gradient(180deg, #121212 0%, var(--color-bg-dark) 100%);">
    <div class="container">
        <h1 class="section-title reveal-in">The Media Gallery</h1>
        <p class="section-subtitle reveal-in">Visual records of transformation, fire, and quiet space</p>
        
        <!-- Category Filter Buttons -->
        <div class="gallery-filters reveal-in" style="transition-delay: 0.1s;">
            <button class="filter-btn active" data-filter="all">All Work</button>
            <button class="filter-btn" data-filter="dreadlocks">Dreadlocks</button>
            <button class="filter-btn" data-filter="firedance">Fire Dance</button>
            <button class="filter-btn" data-filter="healing">Healing Sessions</button>
            <button class="filter-btn" data-filter="workshops">Workshops</button>
            <button class="filter-btn" data-filter="events">Events</button>
        </div>
        
        <!-- Gallery Grid -->
        <div class="gallery-grid reveal-in" style="transition-delay: 0.2s; margin-top: 20px;">
            <?php
            $items = get_gallery_items();
            $item_count = 0;
            
            if (!empty($items)) {
                foreach ($items as $item) {
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
                    $item_count++;
                }
            }
            
            // Seed premium fallbacks if database is empty so page never renders blank
            if ($item_count === 0) {
                $placeholders = [
                    ['title' => 'Crochet Installation', 'cat' => 'dreadlocks', 'img' => 'assets/images/hero_dreadlocks.png'],
                    ['title' => 'Ember POI Flow', 'cat' => 'firedance', 'img' => 'assets/images/firedance_performance.png'],
                    ['title' => 'Trauma Release Room', 'cat' => 'healing', 'img' => 'assets/images/breathwork_healing.png'],
                    ['title' => 'Brand Story Portrait', 'cat' => 'events', 'img' => 'assets/images/sarah_profile.png'],
                    ['title' => 'Wool Extension Installs', 'cat' => 'dreadlocks', 'img' => 'assets/images/hero_dreadlocks.png'],
                    ['title' => 'Somatic Healing Circle', 'cat' => 'workshops', 'img' => 'assets/images/breathwork_healing.png'],
                    ['title' => 'Double Staff Fire Spin', 'cat' => 'firedance', 'img' => 'assets/images/firedance_performance.png'],
                    ['title' => 'Primal Breath Session', 'cat' => 'workshops', 'img' => 'assets/images/sarah_profile.png'],
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
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
