/**
 * ==============================================================================
 * 3D KAWAII CHIBI SAKURA MASCOT - FOLLOWS CURSOR EDITION
 * Three.js WebGL - Auto follows mouse with cute head tilt & blink animation
 * ==============================================================================
 */

(function () {
  'use strict';

  function loadThreeJs(callback) {
    if (window.THREE) { callback(); return; }
    var script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js';
    script.async = true;
    script.onload = callback;
    script.onerror = function () { initCuteCanvasFallback(); };
    document.head.appendChild(script);
  }

  function initCuteMascot3D() {
    var canvas = document.getElementById('chibi-mascot-canvas');
    if (!canvas) return;

    var container = canvas.parentElement;
    var width = container.clientWidth || 320;
    var height = container.clientHeight || 290;

    var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
    camera.position.set(0, 0.25, 5.0);

    var renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    // Warm Pastel Lighting
    scene.add(new THREE.AmbientLight(0xfff5f8, 1.1));
    var warmSun = new THREE.DirectionalLight(0xffffff, 0.9);
    warmSun.position.set(3, 4, 4);
    scene.add(warmSun);
    var pinkRim = new THREE.PointLight(0xff758f, 2.2, 10);
    pinkRim.position.set(-2.5, 2, 2);
    scene.add(pinkRim);
    var lavBack = new THREE.PointLight(0xf3e8ff, 1.8, 10);
    lavBack.position.set(2, -1.5, -2);
    scene.add(lavBack);

    var mascot = new THREE.Group();
    scene.add(mascot);

    // HEAD
    var headMat = new THREE.MeshStandardMaterial({ color: 0xfff0f5, roughness: 0.45, metalness: 0.1 });
    var head = new THREE.Mesh(new THREE.SphereGeometry(1.0, 36, 36), headMat);
    head.position.y = 0.35;
    mascot.add(head);

    // EYES (big anime style)
    var eyeMat = new THREE.MeshStandardMaterial({ color: 0x3d2631, roughness: 0.15, metalness: 0.2 });
    var leftEye = new THREE.Mesh(new THREE.SphereGeometry(0.18, 24, 24), eyeMat);
    leftEye.scale.set(1, 1.35, 0.5);
    leftEye.position.set(-0.35, 0.38, 0.92);
    mascot.add(leftEye);
    var rightEye = leftEye.clone();
    rightEye.position.set(0.35, 0.38, 0.92);
    mascot.add(rightEye);

    // Eye catchlights
    var dotMat = new THREE.MeshBasicMaterial({ color: 0xffffff });
    var dotGeo = new THREE.SphereGeometry(0.065, 16, 16);
    [[-0.32, 0.45, 0.99], [-0.38, 0.32, 0.98], [0.38, 0.45, 0.99], [0.32, 0.32, 0.98]].forEach(function(p, i) {
      var d = new THREE.Mesh(dotGeo, dotMat);
      if (i === 1 || i === 3) d.scale.set(0.55, 0.55, 0.55);
      d.position.set(p[0], p[1], p[2]);
      mascot.add(d);
    });

    // BLUSHING CHEEKS
    var blushMat = new THREE.MeshBasicMaterial({ color: 0xff758f, transparent: true, opacity: 0.7 });
    var blushGeo = new THREE.CylinderGeometry(0.16, 0.16, 0.05, 24);
    var leftBlush = new THREE.Mesh(blushGeo, blushMat);
    leftBlush.rotation.set(Math.PI * 0.45, -Math.PI * 0.15, 0);
    leftBlush.position.set(-0.55, 0.22, 0.82);
    mascot.add(leftBlush);
    var rightBlush = leftBlush.clone();
    rightBlush.rotation.set(Math.PI * 0.45, Math.PI * 0.15, 0);
    rightBlush.position.set(0.55, 0.22, 0.82);
    mascot.add(rightBlush);

    // SMILE
    var smileCurve = new THREE.QuadraticBezierCurve3(
      new THREE.Vector3(-0.12, 0.18, 0.98),
      new THREE.Vector3(0, 0.12, 0.99),
      new THREE.Vector3(0.12, 0.18, 0.98)
    );
    mascot.add(new THREE.Mesh(new THREE.TubeGeometry(smileCurve, 12, 0.02, 8, false), new THREE.MeshBasicMaterial({ color: 0x800f2f })));

    // BUNNY EARS
    var earOuter = new THREE.MeshStandardMaterial({ color: 0xfff0f5, roughness: 0.45 });
    var earInner = new THREE.MeshStandardMaterial({ color: 0xffccd5, roughness: 0.5 });
    var earGeo = new THREE.CylinderGeometry(0.2, 0.14, 0.85, 24);
    var earInGeo = new THREE.CylinderGeometry(0.14, 0.09, 0.7, 24);

    function makeEar(x, rz) {
      var g = new THREE.Group();
      var o = new THREE.Mesh(earGeo, earOuter);
      o.scale.set(1, 1, 0.45);
      g.add(o);
      var inner = new THREE.Mesh(earInGeo, earInner);
      inner.scale.set(1, 1, 0.35);
      inner.position.z = 0.05;
      g.add(inner);
      g.position.set(x, 1.45, 0);
      g.rotation.set(-0.1, 0, rz);
      return g;
    }
    var leftEarGroup = makeEar(-0.55, 0.25);
    var rightEarGroup = makeEar(0.55, -0.25);
    mascot.add(leftEarGroup);
    mascot.add(rightEarGroup);

    // SAKURA HAIRPIN
    var flowerGroup = new THREE.Group();
    var petalMat = new THREE.MeshStandardMaterial({ color: 0xff758f, roughness: 0.3 });
    for (var p = 0; p < 5; p++) {
      var pg = new THREE.ConeGeometry(0.12, 0.28, 16);
      var pm = new THREE.Mesh(pg, petalMat);
      var pa = (p / 5) * Math.PI * 2;
      pm.position.set(Math.cos(pa) * 0.16, Math.sin(pa) * 0.16, 0);
      pm.rotation.z = pa - Math.PI * 0.5;
      pm.scale.set(1, 1, 0.3);
      flowerGroup.add(pm);
    }
    flowerGroup.add(new THREE.Mesh(new THREE.SphereGeometry(0.08, 16, 16), new THREE.MeshStandardMaterial({ color: 0xffd166, roughness: 0.2 })));
    flowerGroup.position.set(0.72, 1.1, 0.55);
    flowerGroup.rotation.set(-Math.PI * 0.1, Math.PI * 0.25, 0);
    mascot.add(flowerGroup);

    // HEADPHONES
    var hpBand = new THREE.Mesh(new THREE.TorusGeometry(1.12, 0.08, 16, 40, Math.PI), new THREE.MeshStandardMaterial({ color: 0xffb3c1, roughness: 0.3 }));
    hpBand.position.set(0, 0.35, 0);
    hpBand.rotation.x = -Math.PI * 0.04;
    mascot.add(hpBand);

    var cupMat = new THREE.MeshStandardMaterial({ color: 0xfff0f5, roughness: 0.3 });
    var cupGeo = new THREE.CylinderGeometry(0.36, 0.36, 0.2, 24);
    var decoMat = new THREE.MeshBasicMaterial({ color: 0xff758f });
    var decoGeo = new THREE.SphereGeometry(0.12, 16, 16);

    [[-1.05, -1.16], [1.05, 1.16]].forEach(function(pos) {
      var cup = new THREE.Mesh(cupGeo, cupMat);
      cup.position.set(pos[0], 0.35, 0);
      cup.rotation.z = Math.PI * 0.5;
      mascot.add(cup);
      var deco = new THREE.Mesh(decoGeo, decoMat);
      deco.position.set(pos[1], 0.35, 0);
      mascot.add(deco);
    });

    // RIBBON BOW
    var bowMat = new THREE.MeshStandardMaterial({ color: 0xff758f, roughness: 0.3 });
    var bowGeo = new THREE.ConeGeometry(0.18, 0.32, 16);
    var ribbonGroup = new THREE.Group();
    var lb = new THREE.Mesh(bowGeo, bowMat);
    lb.rotation.z = Math.PI * 0.5;
    lb.position.x = -0.16;
    ribbonGroup.add(lb);
    var rb = new THREE.Mesh(bowGeo, bowMat);
    rb.rotation.z = -Math.PI * 0.5;
    rb.position.x = 0.16;
    ribbonGroup.add(rb);
    ribbonGroup.add(new THREE.Mesh(new THREE.SphereGeometry(0.1, 16, 16), bowMat));
    ribbonGroup.position.set(0, -0.62, 0.85);
    mascot.add(ribbonGroup);

    // BODY
    mascot.add(function() {
      var b = new THREE.Mesh(new THREE.CylinderGeometry(0.55, 0.72, 0.95, 24), new THREE.MeshStandardMaterial({ color: 0xffccd5, roughness: 0.5 }));
      b.position.y = -0.92;
      return b;
    }());

    // PAWS
    var pawMat = new THREE.MeshStandardMaterial({ color: 0xfff0f5, roughness: 0.4 });
    var pawGeo = new THREE.SphereGeometry(0.15, 16, 16);
    [[-0.35, 0.35]].forEach(function() {
      var lp = new THREE.Mesh(pawGeo, pawMat);
      lp.position.set(-0.35, -0.75, 0.65);
      mascot.add(lp);
      var rp = new THREE.Mesh(pawGeo, pawMat);
      rp.position.set(0.35, -0.75, 0.65);
      mascot.add(rp);
    });

    // ORBITING SAKURA PETALS
    var petalsOrbit = new THREE.Group();
    var opMat = new THREE.MeshStandardMaterial({ color: 0xffb3c1, roughness: 0.2, side: THREE.DoubleSide });
    var opGeo = new THREE.ConeGeometry(0.12, 0.28, 12);
    var petalData = [];
    for (var k = 0; k < 6; k++) {
      var op = new THREE.Mesh(opGeo, opMat);
      op.scale.set(1, 1, 0.25);
      var ra = (k / 6) * Math.PI * 2;
      var rad = 1.6 + (k % 2) * 0.35;
      op.position.set(Math.cos(ra) * rad, (Math.random() - 0.5) * 1.5, Math.sin(ra) * rad);
      op.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, Math.random() * Math.PI);
      petalsOrbit.add(op);
      petalData.push({ mesh: op, baseAngle: ra, radius: rad, speed: 0.015 + Math.random() * 0.01, yBase: op.position.y });
    }
    scene.add(petalsOrbit);

    // ============ CURSOR FOLLOW SYSTEM ============
    var mouseX = 0, mouseY = 0;
    var targetRotY = 0, targetRotX = 0;

    // Track mouse position relative to viewport center
    function onMouseMove(e) {
      var rect = container.getBoundingClientRect();
      var cx = rect.left + rect.width / 2;
      var cy = rect.top + rect.height / 2;
      mouseX = (e.clientX - cx) / (rect.width / 2);  // -1 to 1
      mouseY = (e.clientY - cy) / (rect.height / 2); // -1 to 1
    }

    // Listen on entire document so mascot follows cursor everywhere
    document.addEventListener('mousemove', onMouseMove);

    // Touch support
    document.addEventListener('touchmove', function(e) {
      if (e.touches.length === 1) {
        onMouseMove({ clientX: e.touches[0].clientX, clientY: e.touches[0].clientY });
      }
    }, { passive: true });

    // Resize
    window.addEventListener('resize', function() {
      var w = container.clientWidth;
      var h = container.clientHeight;
      camera.aspect = w / h;
      camera.updateProjectionMatrix();
      renderer.setSize(w, h);
    });

    // ============ ANIMATION LOOP ============
    var clock = new THREE.Clock();
    var blinkTimer = 0;
    var isBlinking = false;

    function animate() {
      requestAnimationFrame(animate);
      var elapsed = clock.getElapsedTime();

      // Smooth follow cursor with damping
      targetRotY = mouseX * 0.6;  // Max tilt ±0.6 rad
      targetRotX = mouseY * 0.3;  // Max tilt ±0.3 rad

      mascot.rotation.y += (targetRotY - mascot.rotation.y) * 0.06;
      mascot.rotation.x += (targetRotX - mascot.rotation.x) * 0.06;

      // Cute idle bobbing
      mascot.position.y = Math.sin(elapsed * 2.2) * 0.07;

      // Ear sway (reacts more when cursor moves)
      var earSway = 0.05 + Math.abs(mouseX) * 0.03;
      leftEarGroup.rotation.z = 0.25 + Math.sin(elapsed * 3) * earSway;
      rightEarGroup.rotation.z = -0.25 - Math.sin(elapsed * 3) * earSway;

      // Blink animation (every ~3-5 seconds)
      blinkTimer += 0.016;
      if (!isBlinking && blinkTimer > 3 + Math.random() * 2) {
        isBlinking = true;
        blinkTimer = 0;
      }
      if (isBlinking) {
        var blinkPhase = blinkTimer / 0.15;
        if (blinkPhase < 1) {
          leftEye.scale.y = 1.35 * (1 - blinkPhase * 0.9);
          rightEye.scale.y = 1.35 * (1 - blinkPhase * 0.9);
        } else if (blinkPhase < 2) {
          leftEye.scale.y = 1.35 * (0.1 + (blinkPhase - 1) * 0.9);
          rightEye.scale.y = 1.35 * (0.1 + (blinkPhase - 1) * 0.9);
        } else {
          leftEye.scale.y = 1.35;
          rightEye.scale.y = 1.35;
          isBlinking = false;
          blinkTimer = 0;
        }
      }

      // Orbiting petals
      for (var j = 0; j < petalData.length; j++) {
        var pd = petalData[j];
        pd.baseAngle += pd.speed;
        pd.mesh.position.x = Math.cos(pd.baseAngle) * pd.radius;
        pd.mesh.position.z = Math.sin(pd.baseAngle) * pd.radius;
        pd.mesh.position.y = pd.yBase + Math.sin(elapsed * 2 + j) * 0.2;
        pd.mesh.rotation.x += 0.02;
        pd.mesh.rotation.y += 0.03;
      }

      // Blush pulse
      blushMat.opacity = 0.6 + Math.sin(elapsed * 2) * 0.2;

      // Flower hairpin gentle wobble
      flowerGroup.rotation.z = Math.sin(elapsed * 2.5) * 0.08;

      renderer.render(scene, camera);
    }

    animate();
  }

  function initCuteCanvasFallback() {
    var canvas = document.getElementById('chibi-mascot-canvas');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var w = canvas.width = canvas.parentElement.clientWidth || 320;
    var h = canvas.height = canvas.parentElement.clientHeight || 290;
    var mx = 0, my = 0;
    document.addEventListener('mousemove', function(e) {
      mx = (e.clientX / window.innerWidth - 0.5) * 2;
      my = (e.clientY / window.innerHeight - 0.5) * 2;
    });
    var angle = 0;
    function renderCute2D() {
      ctx.clearRect(0, 0, w, h);
      ctx.save();
      ctx.translate(w / 2 + mx * 20, h / 2 + my * 10);
      var rad = ctx.createRadialGradient(0, 0, 10, 0, 0, 90);
      rad.addColorStop(0, 'rgba(255, 182, 193, 0.4)');
      rad.addColorStop(1, 'transparent');
      ctx.fillStyle = rad;
      ctx.fillRect(-w / 2, -h / 2, w, h);
      ctx.beginPath();
      ctx.arc(0, -10 + Math.sin(angle) * 6, 50, 0, Math.PI * 2);
      ctx.fillStyle = '#fff0f5';
      ctx.fill();
      ctx.strokeStyle = '#ffb3c1';
      ctx.lineWidth = 3;
      ctx.stroke();
      ctx.fillStyle = 'rgba(255, 117, 143, 0.6)';
      ctx.beginPath();
      ctx.arc(-30, 2 + Math.sin(angle) * 6, 9, 0, Math.PI * 2);
      ctx.arc(30, 2 + Math.sin(angle) * 6, 9, 0, Math.PI * 2);
      ctx.fill();
      ctx.fillStyle = '#3d2631';
      ctx.beginPath();
      ctx.arc(-18, -12 + Math.sin(angle) * 6, 7, 0, Math.PI * 2);
      ctx.arc(18, -12 + Math.sin(angle) * 6, 7, 0, Math.PI * 2);
      ctx.fill();
      ctx.restore();
      angle += 0.04;
      requestAnimationFrame(renderCute2D);
    }
    renderCute2D();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () { loadThreeJs(initCuteMascot3D); });
  } else {
    loadThreeJs(initCuteMascot3D);
  }
})();
