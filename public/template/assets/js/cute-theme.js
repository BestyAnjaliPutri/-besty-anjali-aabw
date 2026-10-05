/**
 * ==============================================================================
 * CUTE SAKURA PETALS & INTERACTIVE PARTICLES ENGINE
 * High-performance, lightweight falling cherry blossoms & micro-interactions
 * ==============================================================================
 */

(function () {
  'use strict';

  // 1. SETUP CANVAS SAKURA
  var canvas, ctx, width, height;
  var petals = [];
  var totalPetals = 28; // Optimal count for beauty & smooth 60fps
  var isSakuraActive = localStorage.getItem('cuteSakuraActive') !== 'false';
  var animationFrameId = null;

  function initSakura() {
    canvas = document.createElement('canvas');
    canvas.id = 'sakura-canvas';
    document.body.prepend(canvas);
    ctx = canvas.getContext('2d');

    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    for (var i = 0; i < totalPetals; i++) {
      petals.push(createPetal(true));
    }

    if (isSakuraActive) {
      animate();
    } else {
      canvas.style.display = 'none';
    }

    createToggleButton();
    initClickSparkles();
  }

  function resizeCanvas() {
    if (!canvas) return;
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
  }

  function createPetal(isInitial) {
    return {
      x: Math.random() * (width || window.innerWidth),
      y: isInitial ? Math.random() * (height || window.innerHeight) : -20,
      size: Math.random() * 8 + 9, // 9px to 17px
      speedY: Math.random() * 0.9 + 0.7,
      speedX: Math.random() * 0.8 - 0.4,
      swayAngle: Math.random() * Math.PI * 2,
      swaySpeed: Math.random() * 0.02 + 0.01,
      swayDistance: Math.random() * 20 + 10,
      rotation: Math.random() * Math.PI * 2,
      rotSpeed: (Math.random() - 0.5) * 0.03,
      flip: Math.random() * Math.PI,
      flipSpeed: Math.random() * 0.03 + 0.01,
      color: getRandomPetalColor(),
      opacity: Math.random() * 0.35 + 0.65
    };
  }

  function getRandomPetalColor() {
    var colors = [
      'rgba(255, 182, 193, ', // Light Pink
      'rgba(255, 192, 203, ', // Pink
      'rgba(255, 209, 220, ', // Pastel Rose
      'rgba(255, 143, 163, ', // Deep Sakura Pink
      'rgba(255, 225, 235, '  // Soft Milky Pink
    ];
    return colors[Math.floor(Math.random() * colors.length)];
  }

  function drawPetal(p) {
    ctx.save();
    ctx.translate(p.x, p.y);
    ctx.rotate(p.rotation);
    ctx.scale(Math.cos(p.flip), 1); // 3D flip illusion

    ctx.beginPath();
    ctx.fillStyle = p.color + p.opacity + ')';

    // Pretty Sakura Petal shape (curved organic bezier petal)
    var s = p.size;
    ctx.moveTo(0, -s);
    ctx.bezierCurveTo(-s * 0.8, -s * 0.5, -s * 0.8, s * 0.5, 0, s);
    ctx.bezierCurveTo(s * 0.8, s * 0.5, s * 0.8, -s * 0.5, 0, -s);
    ctx.closePath();
    ctx.fill();

    // Subtle petal center notch
    ctx.beginPath();
    ctx.fillStyle = 'rgba(255, 117, 143, ' + (p.opacity * 0.6) + ')';
    ctx.arc(0, -s * 0.85, s * 0.18, 0, Math.PI * 2);
    ctx.fill();

    ctx.restore();
  }

  function animate() {
    if (!isSakuraActive) return;

    ctx.clearRect(0, 0, width, height);

    for (var i = 0; i < petals.length; i++) {
      var p = petals[i];

      p.swayAngle += p.swaySpeed;
      p.x += Math.sin(p.swayAngle) * 0.8 + p.speedX;
      p.y += p.speedY;
      p.rotation += p.rotSpeed;
      p.flip += p.flipSpeed;

      // Wrap around edges
      if (p.y > height + 25) {
        petals[i] = createPetal(false);
      }
      if (p.x < -20) p.x = width + 10;
      if (p.x > width + 20) p.x = -10;

      drawPetal(p);
    }

    animationFrameId = requestAnimationFrame(animate);
  }

  // Auto pause when tab is backgrounded
  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      if (animationFrameId) cancelAnimationFrame(animationFrameId);
    } else if (isSakuraActive) {
      animate();
    }
  });

  // 2. CUTE FLOATING TOGGLE BUTTON
  function createToggleButton() {
    var btn = document.createElement('div');
    btn.className = 'sakura-toggle-btn';
    btn.setAttribute('title', 'Toggle Animasi Bunga Sakura (On/Off)');
    btn.innerHTML = '🌸';

    btn.addEventListener('click', function () {
      isSakuraActive = !isSakuraActive;
      localStorage.setItem('cuteSakuraActive', isSakuraActive);

      if (isSakuraActive) {
        canvas.style.display = 'block';
        animate();
        showCuteToast('Animasi Sakura Diaktifkan! 🌸✨');
      } else {
        canvas.style.display = 'none';
        if (animationFrameId) cancelAnimationFrame(animationFrameId);
        showCuteToast('Animasi Sakura Dijeda ✨');
      }
    });

    document.body.appendChild(btn);
  }

  function showCuteToast(message) {
    var toast = document.createElement('div');
    toast.style.cssText =
      'position: fixed; bottom: 80px; right: 22px; background: linear-gradient(135deg, #ff758f, #ff8fa3);' +
      'color: #fff; padding: 10px 18px; border-radius: 25px; font-family: "Quicksand", sans-serif; font-weight: 700;' +
      'font-size: 13px; box-shadow: 0 6px 20px rgba(255, 117, 143, 0.4); z-index: 99999; animation: cutePageFadeIn 0.3s forwards;';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(function () {
      toast.style.opacity = '0';
      toast.style.transition = 'opacity 0.4s ease';
      setTimeout(function () {
        if (toast.parentNode) toast.parentNode.removeChild(toast);
      }, 400);
    }, 2000);
  }

  // 3. CUTE CLICK SPARKLE PARTICLES
  function initClickSparkles() {
    var icons = ['🌸', '✨', '💖', '🎀', '🌷', '⭐'];

    document.addEventListener('click', function (e) {
      // Don't trigger on text selection or right click
      if (e.button !== 0) return;

      var x = e.clientX;
      var y = e.clientY;

      for (var i = 0; i < 4; i++) {
        var sparkle = document.createElement('span');
        sparkle.className = 'cute-sparkle';
        sparkle.textContent = icons[Math.floor(Math.random() * icons.length)];

        var angle = Math.random() * Math.PI * 2;
        var dist = Math.random() * 40 + 20;
        var dx = Math.cos(angle) * dist + 'px';
        var dy = Math.sin(angle) * dist + 'px';
        var rot = Math.random() * 360 - 180 + 'deg';

        sparkle.style.left = x + 'px';
        sparkle.style.top = y + 'px';
        sparkle.style.setProperty('--dx', dx);
        sparkle.style.setProperty('--dy', dy);
        sparkle.style.setProperty('--rot', rot);

        document.body.appendChild(sparkle);

        (function (el) {
          setTimeout(function () {
            if (el.parentNode) el.parentNode.removeChild(el);
          }, 750);
        })(sparkle);
      }
    });
  }

  // 4. CUTE PAGE TRANSITION OVERLAY
  function initPageTransition() {
    // Create transition overlay
    var overlay = document.createElement('div');
    overlay.id = 'cute-page-transition';
    overlay.style.cssText =
      'position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 999999;' +
      'pointer-events: none; opacity: 0; transition: opacity 0.3s ease;' +
      'background: radial-gradient(ellipse at center, rgba(255,240,243,0.95) 0%, rgba(255,179,193,0.85) 60%, rgba(255,117,143,0.7) 100%);' +
      'display: flex; align-items: center; justify-content: center; flex-direction: column;';
    overlay.innerHTML =
      '<div style="font-size: 52px; animation: cuteFloat 1s ease-in-out infinite;">🌸</div>' +
      '<div style="color: #c9184a; font-family: Quicksand, sans-serif; font-weight: 800; font-size: 15px; margin-top: 8px; letter-spacing: 1px;">Loading...</div>';
    document.body.appendChild(overlay);

    // Intercept sidebar navigation clicks
    var sidebarLinks = document.querySelectorAll('.main-sidebar .sidebar-menu li a[href]');
    for (var i = 0; i < sidebarLinks.length; i++) {
      (function(link) {
        var href = link.getAttribute('href');
        // Skip dropdown toggles and javascript: links
        if (!href || href === '#' || href.indexOf('javascript') === 0 || link.classList.contains('has-dropdown')) return;

        link.addEventListener('click', function(e) {
          e.preventDefault();

          // Burst sparkles from the clicked link
          var rect = link.getBoundingClientRect();
          var cx = rect.left + rect.width / 2;
          var cy = rect.top + rect.height / 2;
          burstSparkles(cx, cy, 8);

          // Show overlay with cute animation
          overlay.style.opacity = '1';
          overlay.style.pointerEvents = 'all';

          setTimeout(function() {
            window.location.href = href;
          }, 350);
        });
      })(sidebarLinks[i]);
    }
  }

  // Burst sparkles effect (used for navigation and interactions)
  function burstSparkles(x, y, count) {
    var icons = ['🌸', '✨', '💖', '🎀', '🌷', '⭐', '💕', '🦋'];
    for (var i = 0; i < count; i++) {
      var sparkle = document.createElement('span');
      sparkle.className = 'cute-sparkle';
      sparkle.textContent = icons[Math.floor(Math.random() * icons.length)];

      var angle = (i / count) * Math.PI * 2 + Math.random() * 0.5;
      var dist = Math.random() * 60 + 30;
      sparkle.style.left = x + 'px';
      sparkle.style.top = y + 'px';
      sparkle.style.setProperty('--dx', Math.cos(angle) * dist + 'px');
      sparkle.style.setProperty('--dy', Math.sin(angle) * dist + 'px');
      sparkle.style.setProperty('--rot', (Math.random() * 360 - 180) + 'deg');
      sparkle.style.fontSize = (Math.random() * 10 + 14) + 'px';

      document.body.appendChild(sparkle);
      (function(el) {
        setTimeout(function() { if (el.parentNode) el.parentNode.removeChild(el); }, 900);
      })(sparkle);
    }
  }

  // 5. SIDEBAR ICON HOVER WOBBLE ANIMATION
  function initSidebarIconWobble() {
    var sidebarIcons = document.querySelectorAll('.main-sidebar .sidebar-menu li a > i');
    for (var i = 0; i < sidebarIcons.length; i++) {
      (function(icon) {
        icon.addEventListener('mouseenter', function() {
          icon.style.animation = 'cuteIconWobble 0.5s ease';
          setTimeout(function() { icon.style.animation = ''; }, 500);
        });
      })(sidebarIcons[i]);
    }

    // Inject the wobble keyframes if not present
    if (!document.getElementById('cute-wobble-keyframes')) {
      var style = document.createElement('style');
      style.id = 'cute-wobble-keyframes';
      style.textContent =
        '@keyframes cuteIconWobble {' +
        '0% { transform: scale(1) rotate(0deg); }' +
        '25% { transform: scale(1.15) rotate(-8deg); }' +
        '50% { transform: scale(1.1) rotate(6deg); }' +
        '75% { transform: scale(1.08) rotate(-4deg); }' +
        '100% { transform: scale(1) rotate(0deg); }' +
        '}';
      document.head.appendChild(style);
    }
  }

  // 6. PINK GLOWING LEFT EDGE STRIP FOR SIDEBAR
  function initSidebarGlowStrip() {
    var sidebar = document.querySelector('.main-sidebar');
    if (!sidebar) return;

    var strip = document.createElement('div');
    strip.style.cssText =
      'position: absolute; left: 0; top: 0; width: 4px; height: 100%;' +
      'background: linear-gradient(180deg, #ff758f 0%, #ffb3c1 30%, #ff4d6d 60%, #ff8fa3 100%);' +
      'z-index: 10; border-radius: 0 4px 4px 0;' +
      'box-shadow: 0 0 12px rgba(255, 117, 143, 0.5), 0 0 24px rgba(255, 77, 109, 0.25);' +
      'animation: glowPulse 3s ease-in-out infinite;';
    sidebar.appendChild(strip);

    if (!document.getElementById('glow-pulse-keyframes')) {
      var style = document.createElement('style');
      style.id = 'glow-pulse-keyframes';
      style.textContent =
        '@keyframes glowPulse {' +
        '0%, 100% { box-shadow: 0 0 12px rgba(255,117,143,0.5), 0 0 24px rgba(255,77,109,0.25); opacity: 1; }' +
        '50% { box-shadow: 0 0 20px rgba(255,117,143,0.8), 0 0 36px rgba(255,77,109,0.4); opacity: 0.85; }' +
        '}';
      document.head.appendChild(style);
    }
  }

  // Run on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
      initSakura();
      initPageTransition();
      initSidebarIconWobble();
      initSidebarGlowStrip();
    });
  } else {
    initSakura();
    initPageTransition();
    initSidebarIconWobble();
    initSidebarGlowStrip();
  }
})();
