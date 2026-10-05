/**
 * ==============================================================================
 * 3D INTERACTIVE HIRO MASCOT & VIEWPORT CONTROLS
 * Three.js WebGL Interactive Character with Drag-to-Rotate & Idle Respiration
 * Matching https://fauzi-iskandar-aabw.vercel.app
 * ==============================================================================
 */

(function () {
  'use strict';

  function loadThreeJs(callback) {
    if (window.THREE) {
      callback();
      return;
    }
    var script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js';
    script.async = true;
    script.onload = function () {
      callback();
    };
    script.onerror = function () {
      console.warn('Three.js failed to load from CDN. Using Canvas 2D fallback.');
      initCanvasFallback();
    };
    document.head.appendChild(script);
  }

  function initHiro3D() {
    var canvas = document.getElementById('hiro-canvas');
    if (!canvas) return;

    var container = canvas.parentElement;
    var width = container.clientWidth || 320;
    var height = container.clientHeight || 290;

    // 1. Scene, Camera, Renderer
    var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
    camera.position.set(0, 0.2, 5.2);

    var renderer = new THREE.WebGLRenderer({
      canvas: canvas,
      alpha: true,
      antialias: true
    });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    // 2. Lights
    var ambientLight = new THREE.AmbientLight(0x38bdf8, 0.9);
    scene.add(ambientLight);

    var mainLight = new THREE.DirectionalLight(0xffffff, 1.2);
    mainLight.position.set(3, 4, 4);
    scene.add(mainLight);

    var cyanPoint = new THREE.PointLight(0x00f0ff, 2.5, 12);
    cyanPoint.position.set(-2.5, 1.5, 2.5);
    scene.add(cyanPoint);

    var blueBackLight = new THREE.PointLight(0x1d4ed8, 2.0, 10);
    blueBackLight.position.set(0, -2, -3);
    scene.add(blueBackLight);

    // 3. Hiro Character Group
    var hiro = new THREE.Group();
    scene.add(hiro);

    // Head (Metallic Navy/Cyber Sphere)
    var headGeo = new THREE.SphereGeometry(1.0, 36, 36);
    var headMat = new THREE.MeshStandardMaterial({
      color: 0x1d3557,
      roughness: 0.35,
      metalness: 0.55
    });
    var head = new THREE.Mesh(headGeo, headMat);
    head.position.y = 0.35;
    hiro.add(head);

    // Visor / Face Screen (Glossy Dark)
    var visorGeo = new THREE.SphereGeometry(0.96, 32, 16, 0, Math.PI, 0, Math.PI * 0.55);
    var visorMat = new THREE.MeshStandardMaterial({
      color: 0x050a14,
      roughness: 0.1,
      metalness: 0.9
    });
    var visor = new THREE.Mesh(visorGeo, visorMat);
    visor.rotation.x = Math.PI * 0.45;
    visor.rotation.y = Math.PI;
    visor.position.set(0, 0.3, 0.08);
    hiro.add(visor);

    // Glowing Cyan Anime Visor Eyes
    var eyeGeo = new THREE.BoxGeometry(0.36, 0.08, 0.05);
    var eyeMat = new THREE.MeshBasicMaterial({
      color: 0x00f0ff
    });

    var leftEye = new THREE.Mesh(eyeGeo, eyeMat);
    leftEye.position.set(-0.35, 0.35, 0.94);
    leftEye.rotation.z = -0.06;
    hiro.add(leftEye);

    var rightEye = new THREE.Mesh(eyeGeo, eyeMat);
    rightEye.position.set(0.35, 0.35, 0.94);
    rightEye.rotation.z = 0.06;
    hiro.add(rightEye);

    // Spiky Anime Hair (Cluster of stylish cyan cyber crystal cones)
    var hairGroup = new THREE.Group();
    var spikeMat = new THREE.MeshStandardMaterial({
      color: 0x0284c7,
      roughness: 0.25,
      metalness: 0.6,
      emissive: 0x00f0ff,
      emissiveIntensity: 0.3
    });

    var spikeConfigs = [
      { x: 0, y: 1.45, z: 0.1, rx: -0.1, rz: 0, s: [0.32, 0.9, 0.28] },
      { x: -0.4, y: 1.38, z: 0.15, rx: -0.15, rz: 0.3, s: [0.28, 0.85, 0.25] },
      { x: 0.4, y: 1.38, z: 0.15, rx: -0.15, rz: -0.3, s: [0.28, 0.85, 0.25] },
      { x: -0.7, y: 1.15, z: 0.0, rx: 0, rz: 0.6, s: [0.26, 0.75, 0.24] },
      { x: 0.7, y: 1.15, z: 0.0, rx: 0, rz: -0.6, s: [0.26, 0.75, 0.24] },
      { x: -0.25, y: 1.3, z: -0.35, rx: 0.35, rz: 0.2, s: [0.28, 0.8, 0.26] },
      { x: 0.25, y: 1.3, z: -0.35, rx: 0.35, rz: -0.2, s: [0.28, 0.8, 0.26] },
      { x: 0, y: 1.35, z: -0.4, rx: 0.45, rz: 0, s: [0.3, 0.85, 0.28] }
    ];

    spikeConfigs.forEach(function (cfg) {
      var coneGeo = new THREE.ConeGeometry(cfg.s[0], cfg.s[1], 5);
      var spike = new THREE.Mesh(coneGeo, spikeMat);
      spike.position.set(cfg.x, cfg.y, cfg.z);
      spike.rotation.x = cfg.rx;
      spike.rotation.z = cfg.rz;
      hairGroup.add(spike);
    });
    hiro.add(hairGroup);

    // Headphones (White Band + Glowing Cyan Earcups)
    var bandGeo = new THREE.TorusGeometry(1.15, 0.08, 16, 40, Math.PI);
    var bandMat = new THREE.MeshStandardMaterial({
      color: 0xf8fafc,
      roughness: 0.3
    });
    var band = new THREE.Mesh(bandGeo, bandMat);
    band.position.set(0, 0.35, 0);
    band.rotation.x = -Math.PI * 0.05;
    hiro.add(band);

    // Earcups
    var earcupGeo = new THREE.CylinderGeometry(0.38, 0.38, 0.22, 24);
    var earcupMat = new THREE.MeshStandardMaterial({
      color: 0x0f172a,
      roughness: 0.3,
      metalness: 0.7
    });

    var ringMat = new THREE.MeshBasicMaterial({
      color: 0x00f0ff
    });
    var ringGeo = new THREE.TorusGeometry(0.28, 0.04, 16, 32);

    // Left earcup
    var leftCup = new THREE.Mesh(earcupGeo, earcupMat);
    leftCup.position.set(-1.08, 0.35, 0);
    leftCup.rotation.z = Math.PI * 0.5;
    hiro.add(leftCup);

    var leftRing = new THREE.Mesh(ringGeo, ringMat);
    leftRing.position.set(-1.2, 0.35, 0);
    leftRing.rotation.y = Math.PI * 0.5;
    hiro.add(leftRing);

    // Right earcup
    var rightCup = new THREE.Mesh(earcupGeo, earcupMat);
    rightCup.position.set(1.08, 0.35, 0);
    rightCup.rotation.z = Math.PI * 0.5;
    hiro.add(rightCup);

    var rightRing = new THREE.Mesh(ringGeo, ringMat);
    rightRing.position.set(1.2, 0.35, 0);
    rightRing.rotation.y = Math.PI * 0.5;
    hiro.add(rightRing);

    // Jagged Anime White Collar
    var collarGroup = new THREE.Group();
    var collarMat = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      roughness: 0.4
    });
    for (var i = 0; i < 9; i++) {
      var toothGeo = new THREE.ConeGeometry(0.2, 0.45, 4);
      var tooth = new THREE.Mesh(toothGeo, collarMat);
      var angle = (i / 9) * Math.PI * 2;
      tooth.position.set(Math.cos(angle) * 0.78, -0.45, Math.sin(angle) * 0.78);
      tooth.rotation.x = Math.PI;
      tooth.rotation.z = Math.sin(angle) * 0.3;
      collarGroup.add(tooth);
    }
    hiro.add(collarGroup);

    // Cyber Torso (Rounded dark blue container)
    var torsoGeo = new THREE.CylinderGeometry(0.68, 0.55, 0.95, 24);
    var torsoMat = new THREE.MeshStandardMaterial({
      color: 0x14213d,
      roughness: 0.35,
      metalness: 0.6
    });
    var torso = new THREE.Mesh(torsoGeo, torsoMat);
    torso.position.y = -0.9;
    hiro.add(torso);

    // Torso Center Glowing Strip
    var stripGeo = new THREE.BoxGeometry(0.1, 0.7, 0.05);
    var stripMat = new THREE.MeshBasicMaterial({ color: 0x00f0ff });
    var strip = new THREE.Mesh(stripGeo, stripMat);
    strip.position.set(0, -0.88, 0.65);
    hiro.add(strip);

    // Hologram Pedestal Base (Below Hiro)
    var holoGeo = new THREE.RingGeometry(1.2, 1.45, 36);
    var holoMat = new THREE.MeshBasicMaterial({
      color: 0x00f0ff,
      side: THREE.DoubleSide,
      transparent: true,
      opacity: 0.35
    });
    var holoRing = new THREE.Mesh(holoGeo, holoMat);
    holoRing.rotation.x = Math.PI * 0.5;
    holoRing.position.y = -1.5;
    hiro.add(holoRing);

    // 4. Interactive Drag-to-Rotate Controls
    var isDragging = false;
    var prevMouseX = 0;
    var prevMouseY = 0;
    var targetRotY = 0;
    var targetRotX = 0;

    container.addEventListener('mousedown', function (e) {
      isDragging = true;
      prevMouseX = e.clientX;
      prevMouseY = e.clientY;
    });

    window.addEventListener('mousemove', function (e) {
      if (!isDragging) return;
      var deltaX = e.clientX - prevMouseX;
      var deltaY = e.clientY - prevMouseY;
      prevMouseX = e.clientX;
      prevMouseY = e.clientY;

      targetRotY += deltaX * 0.008;
      targetRotX += deltaY * 0.005;
      targetRotX = Math.max(-0.4, Math.min(0.4, targetRotX));
    });

    window.addEventListener('mouseup', function () {
      isDragging = false;
    });

    // Touch support for mobile devices
    container.addEventListener('touchstart', function (e) {
      if (e.touches.length === 1) {
        isDragging = true;
        prevMouseX = e.touches[0].clientX;
        prevMouseY = e.touches[0].clientY;
      }
    }, { passive: true });

    window.addEventListener('touchmove', function (e) {
      if (!isDragging || e.touches.length !== 1) return;
      var deltaX = e.touches[0].clientX - prevMouseX;
      var deltaY = e.touches[0].clientY - prevMouseY;
      prevMouseX = e.touches[0].clientX;
      prevMouseY = e.touches[0].clientY;

      targetRotY += deltaX * 0.008;
      targetRotX += deltaY * 0.005;
      targetRotX = Math.max(-0.4, Math.min(0.4, targetRotX));
    }, { passive: true });

    window.addEventListener('touchend', function () {
      isDragging = false;
    });

    // Window Resize Handler
    function onResize() {
      if (!container || !renderer) return;
      var newW = container.clientWidth;
      var newH = container.clientHeight;
      camera.aspect = newW / newH;
      camera.updateProjectionMatrix();
      renderer.setSize(newW, newH);
    }
    window.addEventListener('resize', onResize);

    // 5. Animation Loop
    var clock = new THREE.Clock();

    function animate() {
      requestAnimationFrame(animate);

      var elapsed = clock.getElapsedTime();

      // Smooth interpolation for rotation
      hiro.rotation.y += (targetRotY - hiro.rotation.y) * 0.08;
      hiro.rotation.x += (targetRotX - hiro.rotation.x) * 0.08;

      // When user is not dragging, gently auto-idle
      if (!isDragging) {
        targetRotY += 0.0035; // gentle slow orbit
      }

      // Zero-Gravity Float / Respiration
      hiro.position.y = Math.sin(elapsed * 2.2) * 0.08;
      holoRing.rotation.z = elapsed * 0.6;

      // Pulse eyes slightly
      var eyePulse = 0.85 + Math.sin(elapsed * 4) * 0.15;
      eyeMat.color.setRGB(0, eyePulse, eyePulse);

      renderer.render(scene, camera);
    }

    animate();
  }

  // Fallback 2D Canvas Renderer if Three.js fails or is offline
  function initCanvasFallback() {
    var canvas = document.getElementById('hiro-canvas');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var w = canvas.width = canvas.parentElement.clientWidth || 320;
    var h = canvas.height = canvas.parentElement.clientHeight || 290;

    var angle = 0;
    function render2D() {
      ctx.clearRect(0, 0, w, h);
      ctx.save();
      ctx.translate(w / 2, h / 2);

      // Radial Glow
      var rad = ctx.createRadialGradient(0, 0, 10, 0, 0, 90);
      rad.addColorStop(0, 'rgba(0, 240, 255, 0.35)');
      rad.addColorStop(1, 'transparent');
      ctx.fillStyle = rad;
      ctx.fillRect(-w / 2, -h / 2, w, h);

      // Head
      ctx.beginPath();
      ctx.arc(0, -10 + Math.sin(angle) * 6, 50, 0, Math.PI * 2);
      ctx.fillStyle = '#1d3557';
      ctx.fill();
      ctx.strokeStyle = '#00f0ff';
      ctx.lineWidth = 2.5;
      ctx.stroke();

      // Eyes
      ctx.fillStyle = '#00f0ff';
      ctx.fillRect(-22, -14 + Math.sin(angle) * 6, 16, 5);
      ctx.fillRect(8, -14 + Math.sin(angle) * 6, 16, 5);

      ctx.restore();
      angle += 0.03;
      requestAnimationFrame(render2D);
    }
    render2D();
  }

  // Run on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      loadThreeJs(initHiro3D);
    });
  } else {
    loadThreeJs(initHiro3D);
  }
})();
