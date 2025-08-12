
const cam = document.getElementById('cam');
const overlay = document.getElementById('overlay');
const octx = overlay.getContext('2d');
const capture = document.getElementById('capture');
const cctx = capture.getContext('2d', { willReadFrequently: true });
const startBtn = document.getElementById('startBtn');
const stopBtn = document.getElementById('stopBtn');

let stream = null;
let rafId = null;

function drawLine(a, b, ctx, scaleX, scaleY) {
  ctx.beginPath();
  ctx.moveTo(a.x * scaleX, a.y * scaleY);
  ctx.lineTo(b.x * scaleX, b.y * scaleY);
  ctx.lineWidth = 4;
  ctx.strokeStyle = '#37a';
  ctx.stroke();
}

async function start() {
  try {
    startBtn.disabled = true;
    stopBtn.disabled = false;

    stream = await navigator.mediaDevices.getUserMedia({
      video: {
        facingMode: { ideal: 'environment' },
        width: { ideal: 800 }, height: { ideal: 480 }
      },
      audio: false
    });

    cam.srcObject = stream;
    await cam.play();


    // Size canvases to the actual video frame for pixel-accurate reads
    const vw = cam.videoWidth || 800;
    const vh = cam.videoHeight || 480;
    capture.width = vw; capture.height = vh;

    // Match overlay to the element’s display size
    const rect = cam.getBoundingClientRect();
    overlay.width = rect.width * devicePixelRatio;
    overlay.height = rect.height * devicePixelRatio;

    scanLoop();
  } catch (err) {
    startBtn.disabled = false;
    stop();
  }
}

function stop() {
  if (rafId) cancelAnimationFrame(rafId);
  rafId = null;

  if (stream) {
    stream.getTracks().forEach(t => t.stop());
    stream = null;
  }
  stopBtn.disabled = true;
  startBtn.disabled = false;

  // Clear overlay
  octx.clearRect(0, 0, overlay.width, overlay.height);
}

function scanLoop() {
  rafId = requestAnimationFrame(scanLoop);

  if (!cam.videoWidth) return; // not ready yet

  // Paint current frame into the offscreen capture canvas
  cctx.drawImage(cam, 0, 0, capture.width, capture.height);

  // Read pixels and run jsQR
  const img = cctx.getImageData(0, 0, capture.width, capture.height);
  const code = jsQR(img.data, img.width, img.height, {
    inversionAttempts: 'attemptBoth' // robust under different lighting
  });

  // Prepare overlay
  octx.clearRect(0, 0, overlay.width, overlay.height);
  const scaleX = overlay.width / capture.width;
  const scaleY = overlay.height / capture.height;

  if (code) {
    const loc = code.location;
    drawLine(loc.topLeftCorner, loc.topRightCorner, octx, scaleX, scaleY);
    drawLine(loc.topRightCorner, loc.bottomRightCorner, octx, scaleX, scaleY);
    drawLine(loc.bottomRightCorner, loc.bottomLeftCorner, octx, scaleX, scaleY);
    drawLine(loc.bottomLeftCorner, loc.topLeftCorner, octx, scaleX, scaleY);

    if (onQRCodeResultCallback != null)
      onQRCodeResultCallback(code.data);

  } else {
    // Hint text without spamming
  }
}

startBtn.addEventListener('click', start);
stopBtn.addEventListener('click', stop);

// Optional: auto-start if permissions were previously granted
if (navigator.permissions?.query) {
  navigator.permissions.query({ name: 'camera' }).then(p => {
    if (p.state === 'granted') start();
  }).catch(() => { });
}