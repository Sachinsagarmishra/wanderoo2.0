/**
 * Main Javascript for Wanderoo
 */

document.addEventListener('DOMContentLoaded', () => {
    console.log('Wanderoo initialized');
    
    // Mobile Menu Toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navGlass = document.querySelector('.nav-glass');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', () => {
            navGlass.classList.toggle('active');
            // Basic toggle for demonstration
            if (navGlass.style.display === 'flex') {
                navGlass.style.display = 'none';
            } else {
                navGlass.style.display = 'flex';
                navGlass.style.flexDirection = 'column';
                navGlass.style.position = 'absolute';
                navGlass.style.top = '80px';
                navGlass.style.left = '20px';
                navGlass.style.right = '20px';
                navGlass.style.borderRadius = '20px';
            }
        });
    }

    // Smooth Scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});
