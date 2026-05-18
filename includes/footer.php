<!-- FOOTER -->
<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-brand">
      <a href="<?php echo SITE_PATH; ?>/" class="nav-logo">
        <img src="<?php echo SITE_PATH; ?>/assets/img/wanderoo.svg" alt="Wanderoo Logo">
      </a>
      <p>India's leading B2B incentive travel platform — turning performance into experiences.</p>
    </div>
    <div class="footer-links-grid">
      <div class="footer-col">
        <h4>Destinations</h4>
        <ul>
          <li><a href="#">Singapore</a></li>
          <li><a href="#">Thailand</a></li>
          <li><a href="#">Bali</a></li>
          <li><a href="#">Goa</a></li>
          <li><a href="#">Himachal</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Solutions</h4>
        <ul>
          <li><a href="#">Employee Incentives</a></li>
          <li><a href="#">Dealer Trips</a></li>
          <li><a href="#">Leadership Offsites</a></li>
          <li><a href="#">College Trips</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="<?php echo SITE_PATH; ?>/about">About Us</a></li>
          <li><a href="<?php echo SITE_PATH; ?>/index#case-studies">Case Studies</a></li>
          <li><a href="<?php echo SITE_PATH; ?>/index#how">How It Works</a></li>
          <li><a href="https://wa.me/<?php echo htmlspecialchars(get_site_setting('whatsapp_number', '919113515462')); ?>" target="_blank"><i class="fa-brands fa-whatsapp"></i> WhatsApp Us</a></li>
          <li><a href="tel:<?php echo htmlspecialchars(preg_replace('/[^0-9+]/', '', get_site_setting('site_phone', '+91 91135 15462'))); ?>"><i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars(get_site_setting('site_phone', '+91 91135 15462')); ?></a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Follow Us</h4>
        <div class="social-links">
          <a href="<?php echo htmlspecialchars(get_site_setting('social_linkedin', '#')); ?>" class="social-icon" target="_blank" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
          <a href="<?php echo htmlspecialchars(get_site_setting('social_instagram', '#')); ?>" class="social-icon" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
          <a href="<?php echo htmlspecialchars(get_site_setting('social_facebook', '#')); ?>" class="social-icon" target="_blank" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="<?php echo htmlspecialchars(get_site_setting('social_youtube', '#')); ?>" class="social-icon" target="_blank" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <div class="footer-copyright">
          © <?php echo date('Y'); ?> Wanderoo. All rights reserved.
        </div>
      </div>
    </div>
  </div>
</footer>

<script>
  // Tab switching
  function switchTab(tab, btn) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    
    const intlGrid = document.getElementById('dest-intl');
    const domGrid = document.getElementById('dest-dom');
    
    if (intlGrid && domGrid) {
        intlGrid.style.display = tab === 'intl' ? 'grid' : 'none';
        domGrid.style.display = tab === 'dom' ? 'grid' : 'none';
    }
  }

  // Smooth scroll
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
  });

  // Scroll Reveal Observer
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px"
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
            observer.unobserve(entry.target);
        }
    });
  }, observerOptions);

  document.querySelectorAll('.reveal-section').forEach(section => {
    observer.observe(section);
  });
</script>

<a href="https://wa.me/<?php echo htmlspecialchars(get_site_setting('whatsapp_number', '919113515462')); ?>" class="whatsapp-float" target="_blank" title="Chat with us on WhatsApp">
  <i class="fa-brands fa-whatsapp"></i>
  <span>Chat with us</span>
</a>
<?php echo get_site_setting('footer_scripts'); ?>
</body>
</html>
