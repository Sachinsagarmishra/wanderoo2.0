<!-- FOOTER -->
<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-brand">
      <a href="<?php echo SITE_PATH; ?>/index.php" class="nav-logo">
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
          <li><a href="#">About Us</a></li>
          <li><a href="#">Case Studies</a></li>
          <li><a href="#">How It Works</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Follow Us</h4>
        <div class="social-links">
          <a href="#" class="social-icon">in</a>
          <a href="#" class="social-icon">ig</a>
          <a href="#" class="social-icon">fb</a>
          <a href="#" class="social-icon">yt</a>
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
</body>
</html>
