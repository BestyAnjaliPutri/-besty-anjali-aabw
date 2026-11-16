/**
 * Japanese Sakura Blizzard (Sakura Fubuki) Petal Engine
 * High-performance 60fps canvas particle simulation
 */
(function() {
  const canvas = document.getElementById('sakura-login-canvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width = (canvas.width = window.innerWidth);
  let height = (canvas.height = window.innerHeight);

  window.addEventListener('resize', () => {
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
  });

  // Petal color palette (Authentic Japanese cherry blossoms)
  const colors = [
    { r: 255, g: 183, b: 197 }, // Soft Sakura Pink
    { r: 255, g: 197, b: 211 }, // Pale Sakura Blossom
    { r: 255, g: 158, b: 187 }, // Rose Blush
    { r: 255, g: 220, b: 230 }, // Pure White Pink
    { r: 255, g: 117, b: 143 }  // Vibrant Deep Cherry
  ];

  // Number of petals for lush spring blizzard
  const isMobile = window.innerWidth < 768;
  const TOTAL_PETALS = isMobile ? 45 : 85;

  class SakuraPetal {
    constructor() {
      this.reset(true);
    }

    reset(initial = false) {
      this.x = Math.random() * (width + 200) - 100;
      this.y = initial ? Math.random() * height : -30;
      this.size = Math.random() * 12 + 10; // 10px to 22px
      this.speedY = Math.random() * 1.6 + 1.2; // Fall speed
      this.speedX = Math.random() * 1.8 + 0.8; // Gentle drift rightward

      this.angle = Math.random() * Math.PI * 2;
      this.angleSpeed = (Math.random() - 0.5) * 0.03;

      // 3D flip tumbling effect
      this.flipAngle = Math.random() * Math.PI * 2;
      this.flipSpeed = Math.random() * 0.04 + 0.02;

      // Fluttering sway
      this.swayAngle = Math.random() * Math.PI * 2;
      this.swaySpeed = Math.random() * 0.03 + 0.015;
      this.swayDistance = Math.random() * 1.5 + 0.5;

      this.color = colors[Math.floor(Math.random() * colors.length)];
      this.opacity = Math.random() * 0.35 + 0.65; // 0.65 to 1.0
    }

    update() {
      this.swayAngle += this.swaySpeed;
      this.flipAngle += this.flipSpeed;
      this.angle += this.angleSpeed;

      // Motion calculation
      this.x += this.speedX + Math.sin(this.swayAngle) * this.swayDistance;
      this.y += this.speedY;

      // Reset when falling out of view
      if (this.y > height + 40 || this.x > width + 100) {
        this.reset(false);
      }
    }

    draw() {
      ctx.save();
      ctx.translate(this.x, this.y);
      ctx.rotate(this.angle);

      // 3D scale flip illusion
      const flipScale = Math.cos(this.flipAngle);
      ctx.scale(1, flipScale);

      ctx.fillStyle = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.opacity})`;
      ctx.shadowColor = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, 0.3)`;
      ctx.shadowBlur = 4;

      // Draw authentic organic sakura petal shape using bezier curves
      ctx.beginPath();
      ctx.moveTo(0, -this.size);
      ctx.bezierCurveTo(
        this.size * 0.7, -this.size * 0.9,
        this.size * 0.9, this.size * 0.4,
        0, this.size
      );
      ctx.bezierCurveTo(
        -this.size * 0.9, this.size * 0.4,
        -this.size * 0.7, -this.size * 0.9,
        0, -this.size
      );
      ctx.closePath();
      ctx.fill();

      // Subtle inner petal crease line for 3D realism
      ctx.beginPath();
      ctx.moveTo(0, -this.size * 0.7);
      ctx.lineTo(0, this.size * 0.5);
      ctx.strokeStyle = `rgba(255, 255, 255, ${this.opacity * 0.45})`;
      ctx.lineWidth = 1;
      ctx.stroke();

      ctx.restore();
    }
  }

  const petals = [];
  for (let i = 0; i < TOTAL_PETALS; i++) {
    petals.push(new SakuraPetal());
  }

  // Interactive mouse breeze
  let mouseBreeze = 0;
  window.addEventListener('mousemove', (e) => {
    const normX = (e.clientX / width - 0.5) * 2;
    mouseBreeze = normX * 0.8;
  });

  function animate() {
    ctx.clearRect(0, 0, width, height);

    for (let i = 0; i < petals.length; i++) {
      const p = petals[i];
      p.x += mouseBreeze * 0.3;
      p.update();
      p.draw();
    }

    // Decay mouse breeze gradually
    mouseBreeze *= 0.98;

    requestAnimationFrame(animate);
  }

  animate();
})();
