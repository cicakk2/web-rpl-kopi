// ==========================================
// Mobile Navigation Toggle
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('mobileToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // Animate hamburger menu
            const spans = this.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(7px, 7px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -7px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }
    
    // Close mobile menu when clicking on a link
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                navMenu.classList.remove('active');
                const spans = mobileToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    });
});

// ==========================================
// Product Filter Functionality
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    
    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get filter value
                const filterValue = this.getAttribute('data-filter');
                
                // Filter products
                productCards.forEach(card => {
                    if (filterValue === 'all') {
                        card.style.display = 'block';
                        card.style.animation = 'fadeInUp 0.5s ease';
                    } else {
                        const category = card.getAttribute('data-category');
                        if (category === filterValue) {
                            card.style.display = 'block';
                            card.style.animation = 'fadeInUp 0.5s ease';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            });
        });
    }
});

// ==========================================
// Scroll Animations
// ==========================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.feature-card, .product-card, .value-item, .team-member');
    
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});

// ==========================================
// Header Scroll Effect
// ==========================================
let lastScroll = 0;
const header = document.querySelector('.header');

window.addEventListener('scroll', function() {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll <= 0) {
        header.style.boxShadow = 'none';
    } else {
        header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
    }
    
    lastScroll = currentScroll;
});

// ==========================================
// Form Validation
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (!name || !email || !subject || !message) {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return false;
            }
        });
    }
});

// ==========================================
// Smooth Scroll
// ==========================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ==========================================
// Add to Cart Animation (Updated for Product Detail)
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const checkoutButtons = document.querySelectorAll('.btn-checkout');
    const addToCartButtons = document.querySelectorAll('.btn-small');
    
    // For product detail page
    checkoutButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            handleAddToCart(this);
        });
    });
    
    // For product grid (legacy support)
    addToCartButtons.forEach(button => {
        if (button.textContent.includes('Add to Cart')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                handleAddToCart(this);
            });
        }
    });
});

// Helper function for add to cart animation
function handleAddToCart(button) {
    const originalText = button.textContent;
    button.textContent = 'Ditambahkan!';
    button.style.background = '#4CAF50';
    
    // Disable button during animation
    button.disabled = true;
    
    setTimeout(() => {
        button.textContent = originalText;
        button.style.background = '';
        button.disabled = false;
    }, 1500);
}

// ==========================================
// Parallax Effect for Hero
// ==========================================
window.addEventListener('scroll', function() {
    const hero = document.querySelector('.hero');
    if (hero) {
        const scrolled = window.pageYOffset;
        const parallax = scrolled * 0.5;
        hero.style.transform = `translateY(${parallax}px)`;
    }
});

// ==========================================
// Counter Animation (for stats)
// ==========================================
function animateCounter(element, target, duration) {
    let start = 0;
    const increment = target / (duration / 16);
    
    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(start);
        }
    }, 16);
}

// ==========================================
// Image Lazy Loading
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
});

// ==========================================
// Product Detail Page - Additional Interactions
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    // Sticky image height adjustment on resize
    const productDetailImage = document.querySelector('.product-detail-image');
    if (productDetailImage) {
        window.addEventListener('resize', function() {
            // Adjust sticky position based on header height on mobile
            if (window.innerWidth <= 768) {
                productDetailImage.style.position = 'static';
            } else {
                productDetailImage.style.position = 'sticky';
            }
        });
    }
    
    // Product detail scroll tracking (optional analytics)
    const productDetailContent = document.querySelector('.product-detail-content');
    if (productDetailContent) {
        let hasScrolledToPrice = false;
        
        window.addEventListener('scroll', function() {
            const priceSection = document.querySelector('.price-section');
            if (priceSection && !hasScrolledToPrice) {
                const rect = priceSection.getBoundingClientRect();
                if (rect.top < window.innerHeight) {
                    hasScrolledToPrice = true;
                    // You can track this event for analytics
                    // console.log('User scrolled to price section');
                }
            }
        });
    }
});