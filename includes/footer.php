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

<!-- North AI Chat Agent Widget -->
<link rel="stylesheet" href="<?php echo SITE_PATH; ?>/assets/css/ai-chatbot.css">

<!-- Background Blur Overlay -->
<div class="northai-overlay-blur" id="northaiOverlayBlur"></div>

<!-- Floating Trigger Button -->
<div class="northai-widget-container">
    <div class="northai-greeting-bubble" id="northaiGreetBubble">
        <span class="close-bubble" id="northaiCloseBubble"><i class="fa-solid fa-xmark"></i></span>
        Got a team in mind? I've got pricing in 30 seconds.
    </div>
    <button class="northai-floating-btn" id="northaiFloatBtn" title="Chat with North AI">
        <img src="<?php echo SITE_PATH; ?>/<?php echo htmlspecialchars(get_agent_setting('agent_logo', 'assets/img/nothai.png')); ?>" alt="North AI Logo">
    </button>
</div>

<!-- Half-Screen Slide-Out Chat Panel -->
<div class="northai-chat-panel" id="northaiChatPanel">
    <div class="northai-chat-header">
        <div class="northai-header-profile">
            <div class="northai-header-avatar">
                <img src="<?php echo SITE_PATH; ?>/<?php echo htmlspecialchars(get_agent_setting('agent_logo', 'assets/img/nothai.png')); ?>" alt="North AI Avatar">
            </div>
            <div class="northai-header-meta">
                <h3><?php echo htmlspecialchars(get_agent_setting('agent_name', 'North AI')); ?></h3>
                <p><?php echo htmlspecialchars(get_agent_setting('agent_role', 'Your event planning advisor')); ?></p>
            </div>
        </div>
        <div class="northai-header-badges">
            <span class="northai-badge-encrypted"><i class="fa-solid fa-lock" style="font-size: 8px;"></i> Encrypted</span>
            <button class="northai-badge-new" id="northaiNewChatBtn" style="cursor: pointer; border: none; font-family: inherit; font-size: 9px; font-weight: 800; color: #64748B; background: #F1F5F9; padding: 3px 8px; border-radius: 100px; text-transform: uppercase; letter-spacing: 0.05em; display: inline-flex; align-items: center; justify-content: center; height: auto; transition: all 0.2s;">New</button>
            <button class="northai-close-btn" id="northaiCloseChat" aria-label="Close Chat"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    
    <div class="northai-chat-messages" id="northaiMessagesBox">
        <!-- Welcome Screen -->
        <div class="northai-welcome-box" id="northaiWelcomeBox">
            <div class="northai-welcome-avatar">
                <img src="<?php echo SITE_PATH; ?>/<?php echo htmlspecialchars(get_agent_setting('agent_logo', 'assets/img/nothai.png')); ?>" alt="North AI Avatar">
            </div>
            <h2>Hey, I'm <?php echo htmlspecialchars(get_agent_setting('agent_name', 'North AI')); ?></h2>
            <p>Your personal event planning advisor. How can I help?</p>
            
            <!-- Suggestion Grid (6 Primary Categories) -->
            <div class="northai-quick-grid">
                <div class="northai-quick-card" data-topic="goa">
                    <h4>🌴 Goa offsite</h4>
                    <p>50 pax · 3 nights · Premium</p>
                </div>
                <div class="northai-quick-card" data-topic="coorg">
                    <h4>🏔️ Coorg retreat</h4>
                    <p>30 pax leadership</p>
                </div>
                <div class="northai-quick-card" data-topic="phuket">
                    <h4>✈️ Phuket international</h4>
                    <p>60 pax · 4 nights</p>
                </div>
                <div class="northai-quick-card" data-topic="bali">
                    <h4>🌴 Bali offsite</h4>
                    <p>40 pax · Premium</p>
                </div>
                <div class="northai-quick-card" data-topic="munnar">
                    <h4>🏔️ Munnar wellness</h4>
                    <p>25 pax · 3 nights</p>
                </div>
                <div class="northai-quick-card" data-topic="teambuilding">
                    <h4>🎯 Team building</h4>
                    <p>Activities & formats</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="northai-input-container">
        <div class="northai-input-wrapper">
            <input type="text" class="northai-chat-input" id="northaiMessageInput" placeholder="Ask about events, pricing, destinations..." autocomplete="off">
            <button class="northai-send-btn" id="northaiSendBtn" aria-label="Send Message">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
        <div class="northai-footer-tag">
            <span>shared with Wanderoo for planning</span>
            <span>developed by North AI</span>
        </div>
    </div>
</div>

<script src="<?php echo SITE_PATH; ?>/assets/js/ai-chatbot.js"></script>

<a href="https://wa.me/<?php echo htmlspecialchars(get_site_setting('whatsapp_number', '919113515462')); ?>" class="whatsapp-float" target="_blank" title="Chat with us on WhatsApp">
  <i class="fa-brands fa-whatsapp"></i>
  <span>Chat with us</span>
 </a>
<?php echo get_site_setting('footer_scripts'); ?>
</body>
</html>
