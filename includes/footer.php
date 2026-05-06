<!-- FOOTER -->
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <div class="nav-logo">Wander<span>oo</span></div>
      <p>India's leading B2B incentive travel platform — turning performance into experiences.</p>
    </div>
    <div class="footer-links">
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
    </div>
  </div>
  <div class="footer-bottom">
    <p>© <?php echo date('Y'); ?> Wanderoo. All rights reserved.</p>
    <p>Reward. Travel. Repeat.</p>
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
</script>
</body>
</html>
