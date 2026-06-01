/**
 * Main Interactive Website Engine
 * Sarah Agni Personal Brand Website
 */

document.addEventListener('DOMContentLoaded', () => {
    
    /* ==========================================================================
       1. Mobile Navigation & Sticky Header
       ========================================================================== */
    const header = document.querySelector('.main-header');
    const mobileToggle = document.querySelector('.mobile-nav-toggle');
    const mobileNav = document.querySelector('.mobile-nav');
    
    // Toggle Mobile Navigation Drawer
    if (mobileToggle && mobileNav) {
        mobileToggle.addEventListener('click', () => {
            mobileToggle.classList.toggle('open');
            mobileNav.classList.toggle('open');
        });
        
        // Close menu when clicking links
        mobileNav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileToggle.classList.remove('open');
                mobileNav.classList.remove('open');
            });
        });
    }
    
    // Sticky Header Scroll Effect
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    /* ==========================================================================
       2. Back to Top Button
       ========================================================================== */
    const backToTopBtn = document.getElementById('backToTopBtn');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });
        
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ==========================================================================
       3. Scroll-Reveal Observer (Scroll Animations)
       ========================================================================== */
    const revealElements = document.querySelectorAll('.reveal-in');
    
    if ('IntersectionObserver' in window && revealElements.length > 0) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target); // Animate once
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        });
        
        revealElements.forEach(element => {
            revealObserver.observe(element);
        });
    } else {
        // Fallback for older browsers
        revealElements.forEach(element => element.classList.add('active'));
    }

    /* ==========================================================================
       4. Floating Amber Particles (Canvas)
       ========================================================================== */
    const canvas = document.getElementById('particleCanvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let particles = [];
        let animationFrameId;
        
        const resizeCanvas = () => {
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = canvas.parentElement.offsetHeight;
        };
        
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
        
        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = canvas.height + Math.random() * 100;
                this.size = Math.random() * 3.5 + 0.5;
                this.speedY = -(Math.random() * 1.5 + 0.5);
                this.speedX = Math.random() * 1 - 0.5;
                this.opacity = Math.random() * 0.5 + 0.1;
                this.hue = Math.random() > 0.4 ? 28 : 15; // Golden-Amber color hue spectrum
                this.sinStep = Math.random() * 0.05;
                this.sinCounter = Math.random() * 100;
            }
            
            update() {
                this.y += this.speedY;
                this.sinCounter += this.sinStep;
                this.x += this.speedX + Math.sin(this.sinCounter) * 0.2;
                
                // Diminish opacity as it rises higher
                this.opacity -= 0.001;
                
                if (this.y < 0 || this.opacity <= 0) {
                    this.y = canvas.height + Math.random() * 50;
                    this.x = Math.random() * canvas.width;
                    this.opacity = Math.random() * 0.5 + 0.1;
                    this.size = Math.random() * 3.5 + 0.5;
                    this.speedY = -(Math.random() * 1.5 + 0.5);
                }
            }
            
            draw() {
                ctx.save();
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = `hsla(${this.hue}, 100%, 50%, ${this.opacity})`;
                
                // Add soft fire glow aura to larger particles
                if (this.size > 2) {
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = `rgb(255, 138, 0)`;
                }
                ctx.fill();
                ctx.restore();
            }
        }
        
        const initParticles = () => {
            const particleCount = Math.min(60, Math.floor(canvas.width / 20));
            particles = [];
            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }
        };
        
        const animateParticles = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            animationFrameId = requestAnimationFrame(animateParticles);
        };
        
        initParticles();
        animateParticles();
        
        // Reset when resize triggers
        window.addEventListener('resize', () => {
            initParticles();
        });
    }

    /* ==========================================================================
       5. Before/After Image Slider
       ========================================================================== */
    const baContainer = document.querySelector('.before-after-container');
    if (baContainer) {
        const sliderInput = baContainer.querySelector('.before-after-slider-input');
        const imgBefore = baContainer.querySelector('.img-before');
        const sliderHandle = baContainer.querySelector('.slider-handle');
        
        const updateSlider = (val) => {
            imgBefore.style.width = val + '%';
            sliderHandle.style.left = val + '%';
        };
        
        sliderInput.addEventListener('input', (e) => {
            updateSlider(e.target.value);
        });
        
        // Keyboard support
        sliderInput.addEventListener('keydown', (e) => {
            let val = parseInt(sliderInput.value);
            if (e.key === 'ArrowLeft') {
                val = Math.max(0, val - 1);
                sliderInput.value = val;
                updateSlider(val);
            } else if (e.key === 'ArrowRight') {
                val = Math.min(100, val + 1);
                sliderInput.value = val;
                updateSlider(val);
            }
        });
    }

    /* ==========================================================================
       6. Testimonial Carousel
       ========================================================================== */
    const testimonialTrack = document.querySelector('.testimonial-track');
    if (testimonialTrack) {
        const slides = Array.from(testimonialTrack.children);
        const nextBtn = document.querySelector('.carousel-next-btn');
        const prevBtn = document.querySelector('.carousel-prev-btn');
        const dotContainer = document.querySelector('.carousel-dot-container');
        
        let currentIndex = 0;
        let slideInterval;
        
        // Generate navigation dots
        slides.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.classList.add('carousel-dot');
            dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
            if (index === 0) dot.classList.add('active');
            dotContainer.appendChild(dot);
            
            dot.addEventListener('click', () => {
                goToSlide(index);
                resetInterval();
            });
        });
        
        const dots = Array.from(dotContainer.children);
        
        const goToSlide = (index) => {
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;
            
            testimonialTrack.style.transform = `translateX(-${index * 100}%)`;
            dots[currentIndex].classList.remove('active');
            dots[index].classList.add('active');
            currentIndex = index;
        };
        
        const startAutoplay = () => {
            slideInterval = setInterval(() => {
                goToSlide(currentIndex + 1);
            }, 6000);
        };
        
        const resetInterval = () => {
            clearInterval(slideInterval);
            startAutoplay();
        };
        
        if (nextBtn && prevBtn) {
            nextBtn.addEventListener('click', () => {
                goToSlide(currentIndex + 1);
                resetInterval();
            });
            prevBtn.addEventListener('click', () => {
                goToSlide(currentIndex - 1);
                resetInterval();
            });
        }
        
        startAutoplay();
    }

    /* ==========================================================================
       7. Filterable Gallery and Lightbox
       ========================================================================== */
    const galleryItems = Array.from(document.querySelectorAll('.gallery-item'));
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    if (galleryItems.length > 0) {
        let activeGalleryItems = [...galleryItems];
        let currentLightboxIndex = 0;
        
        // Gallery Category Filtering
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const filterValue = btn.getAttribute('data-filter');
                activeGalleryItems = [];
                
                galleryItems.forEach(item => {
                    const matches = filterValue === 'all' || item.getAttribute('data-category') === filterValue;
                    if (matches) {
                        item.style.display = 'block';
                        activeGalleryItems.push(item);
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Lightbox initialization
        const lightbox = document.createElement('div');
        lightbox.classList.add('lightbox');
        lightbox.innerHTML = `
            <button class="lightbox-close" aria-label="Close Lightbox">&times;</button>
            <button class="lightbox-nav lightbox-prev" aria-label="Previous Image"><i class="fas fa-chevron-left"></i></button>
            <div class="lightbox-content-wrapper">
                <img class="lightbox-img" src="" alt="Gallery Lightbox Image">
                <div class="lightbox-caption">
                    <h4 class="lightbox-title"></h4>
                    <span class="lightbox-category"></span>
                </div>
            </div>
            <button class="lightbox-nav lightbox-next" aria-label="Next Image"><i class="fas fa-chevron-right"></i></button>
        `;
        document.body.appendChild(lightbox);
        
        const lightboxImg = lightbox.querySelector('.lightbox-img');
        const lightboxTitle = lightbox.querySelector('.lightbox-title');
        const lightboxCat = lightbox.querySelector('.lightbox-category');
        const closeBtn = lightbox.querySelector('.lightbox-close');
        const prevBtn = lightbox.querySelector('.lightbox-prev');
        const nextBtn = lightbox.querySelector('.lightbox-next');
        
        const openLightbox = (index) => {
            currentLightboxIndex = index;
            const targetItem = activeGalleryItems[currentLightboxIndex];
            const imgSrc = targetItem.getAttribute('data-src');
            const imgTitle = targetItem.getAttribute('data-title');
            const imgCategory = targetItem.getAttribute('data-category');
            
            lightboxImg.src = imgSrc;
            lightboxTitle.textContent = imgTitle;
            lightboxCat.textContent = imgCategory.replace('-', ' ');
            
            lightbox.classList.add('open');
            document.body.style.overflow = 'hidden'; // Lock background scroll
        };
        
        const closeLightbox = () => {
            lightbox.classList.remove('open');
            document.body.style.overflow = '';
        };
        
        const showNext = () => {
            let nextIndex = currentLightboxIndex + 1;
            if (nextIndex >= activeGalleryItems.length) nextIndex = 0;
            openLightbox(nextIndex);
        };
        
        const showPrev = () => {
            let prevIndex = currentLightboxIndex - 1;
            if (prevIndex < 0) prevIndex = activeGalleryItems.length - 1;
            openLightbox(prevIndex);
        };
        
        // Open lightbox click listeners
        galleryItems.forEach(item => {
            item.addEventListener('click', () => {
                const index = activeGalleryItems.indexOf(item);
                if (index !== -1) {
                    openLightbox(index);
                }
            });
        });
        
        // Control Listeners
        closeBtn.addEventListener('click', closeLightbox);
        nextBtn.addEventListener('click', showNext);
        prevBtn.addEventListener('click', showPrev);
        
        // Close on clicking overlay background
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
        
        // Keyboard support
        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('open')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') showNext();
            if (e.key === 'ArrowLeft') showPrev();
        });
    }

    /* ==========================================================================
       8. FAQ Accordion Toggle
       ========================================================================== */
    const faqHeaders = document.querySelectorAll('.faq-header');
    faqHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const item = header.parentElement;
            const content = item.querySelector('.faq-content');
            const isOpen = item.classList.contains('open');
            
            // Close all other open items
            document.querySelectorAll('.faq-item').forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('open')) {
                    otherItem.classList.remove('open');
                    otherItem.querySelector('.faq-content').style.maxHeight = null;
                }
            });
            
            // Toggle current item
            if (isOpen) {
                item.classList.remove('open');
                content.style.maxHeight = null;
            } else {
                item.classList.add('open');
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    });

});
