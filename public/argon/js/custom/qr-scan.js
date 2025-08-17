
const cam = document.getElementById('cam');
const overlay = document.getElementById('overlay');
const octx = overlay.getContext('2d');
const capture = document.getElementById('capture');
const cctx = capture.getContext('2d', { willReadFrequently: true });
const cameraDropdown = document.getElementById('cameraDropdown');
const cameraList = document.getElementById('cameraList');

let stream = null;
let rafId = null;
let cameras = [];
let selectedCameraId = null;
let isScanning = false;

// Function to enumerate available cameras
async function enumerateCameras() {
  try {
    // Check if getUserMedia is supported
    if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
      console.warn('Camera enumeration not supported');
      showCameraError('Camera enumeration not supported in this browser');
      return;
    }

    // Show loading state
    cameraDropdown.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    
    // Get all media devices
    const devices = await navigator.mediaDevices.enumerateDevices();
    
    // Filter for video input devices (cameras)
    cameras = devices.filter(device => device.kind === 'videoinput');
    
    // Update camera dropdown
    updateCameraDropdown();
    
    console.log('Available cameras:', cameras);
    
    // Show success message if cameras found
    if (cameras.length > 0) {
      showCameraSuccess(`${cameras.length} camera(s) found`);
    } else {
      showCameraError('No cameras found. Please check your camera permissions.');
    }
  } catch (error) {
    console.error('Error enumerating cameras:', error);
    showCameraError('Failed to enumerate cameras. Please check permissions.');
    updateCameraDropdown();
  }
}

// Function to show camera error message
function showCameraError(message) {
  // You can implement a toast notification here
  console.error('Camera Error:', message);
  // For now, we'll just log to console
}

// Function to show camera success message
function showCameraSuccess(message) {
  // You can implement a toast notification here
  console.log('Camera Success:', message);
  // For now, we'll just log to console
}



// Function to update camera dropdown
function updateCameraDropdown() {
  // Clear existing camera list except the first default item and refresh button
  const defaultItem = cameraList.querySelector('[data-camera="default"]');
  const refreshItem = cameraList.querySelector('#refreshCameras')?.parentElement;
  cameraList.innerHTML = '';
  
  if (defaultItem) {
    // Update default camera status
    if (selectedCameraId === 'default' && isScanning) {
      defaultItem.innerHTML = `<i class="fas fa-circle text-success"></i> Default Camera (Scanning)`;
      defaultItem.classList.add('active');
    } else if (selectedCameraId === 'default') {
      defaultItem.innerHTML = `<i class="fas fa-circle text-warning"></i> Default Camera (Selected)`;
    } else {
      defaultItem.innerHTML = `<i class="fas fa-circle text-muted"></i> Default Camera`;
    }
    cameraList.appendChild(defaultItem);
  }
  
  // Add divider
  const divider = document.createElement('li');
  divider.innerHTML = '<hr class="dropdown-divider">';
  cameraList.appendChild(divider);
  
  // Add available cameras
  if (cameras.length > 0) {
    cameras.forEach((camera, index) => {
      const li = document.createElement('li');
      const a = document.createElement('a');
      a.className = 'dropdown-item';
      a.href = '#';
      a.dataset.camera = camera.deviceId;
      
      // Use camera label or generate a name
      const cameraName = camera.label || `Camera ${index + 1}`;
      
      // Add status indicator if this camera is currently active
      if (selectedCameraId === camera.deviceId && isScanning) {
        a.innerHTML = `<i class="fas fa-circle text-success"></i> ${cameraName} (Scanning)`;
        a.classList.add('active');
      } else if (selectedCameraId === camera.deviceId) {
        a.innerHTML = `<i class="fas fa-circle text-warning"></i> ${cameraName} (Selected)`;
      } else {
        a.innerHTML = `<i class="fas fa-circle text-muted"></i> ${cameraName}`;
      }
      
      li.appendChild(a);
      cameraList.appendChild(li);
    });
  } else {
    // Show no cameras found message
    const li = document.createElement('li');
    const a = document.createElement('a');
    a.className = 'dropdown-item text-muted';
    a.href = '#';
    a.textContent = 'No cameras found';
    a.style.pointerEvents = 'none';
    li.appendChild(a);
    cameraList.appendChild(li);
  }
  
  // Add refresh button back if it exists
  if (refreshItem) {
    cameraList.appendChild(refreshItem);
  }
  
  // Update dropdown button text
  if (cameras.length > 0) {
    if (isScanning) {
      cameraDropdown.innerHTML = '<i class="fas fa-camera"></i> Camera Active';
    } else {
      cameraDropdown.innerHTML = '<i class="fas fa-camera"></i> Select Camera';
    }
  } else {
    cameraDropdown.innerHTML = '<i class="fas fa-camera"></i> No Cameras';
  }
}

// Function to handle camera selection
function selectCamera(cameraId) {
  // If clicking the same camera that's currently active, toggle start/stop
  if (selectedCameraId === cameraId && isScanning) {
    stop();
    return;
  }
  
  selectedCameraId = cameraId;
  
  // Update dropdown button text
  const selectedCamera = cameras.find(cam => cam.deviceId === cameraId);
  if (selectedCamera) {
    const cameraName = selectedCamera.label || 'Selected Camera';
    cameraDropdown.innerHTML = `<i class="fas fa-camera"></i> ${cameraName}`;
  } else {
    cameraDropdown.innerHTML = '<i class="fas fa-camera"></i> Default Camera';
  }
  
  // If stream is active, restart with new camera
  if (stream) {
    stop();
    setTimeout(() => start(), 500);
  } else {
    // If no stream is active, start scanning with the selected camera
    start();
  }
}

// Safari-specific compatibility function
function isSafari() {
  const ua = navigator.userAgent.toLowerCase();
  return ua.includes('safari') && !ua.includes('chrome');
}

// Enhanced camera enumeration for Safari compatibility
async function enumerateCamerasSafari() {
  try {
    // Show loading state
    cameraDropdown.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    
    // Safari requires getUserMedia to be called before enumerateDevices
    const tempStream = await navigator.mediaDevices.getUserMedia({ video: true });
    tempStream.getTracks().forEach(track => track.stop());
    
    // Now enumerate devices
    const devices = await navigator.mediaDevices.enumerateDevices();
    cameras = devices.filter(device => device.kind === 'videoinput');
    
    updateCameraDropdown();
    console.log('Safari cameras found:', cameras);
    
    // Show success message if cameras found
    if (cameras.length > 0) {
      showCameraSuccess(`${cameras.length} camera(s) found`);
    } else {
      showCameraError('No cameras found. Please check your camera permissions.');
    }
  } catch (error) {
    console.error('Safari camera enumeration error:', error);
    showCameraError('Failed to enumerate cameras. Please check permissions.');
    updateCameraDropdown();
  }
}

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

    // Prepare video constraints based on selected camera
    const videoConstraints = {
      width: { ideal: 400 }, 
      height: { ideal: 400 }
    };

    // If a specific camera is selected, use its deviceId
    if (selectedCameraId && selectedCameraId !== 'default') {
      videoConstraints.deviceId = { exact: selectedCameraId };
    } else {
      // Use default camera with environment facing mode for mobile devices
      // For Safari on macOS, we might want to avoid facingMode constraint
      if (!isSafari()) {
        videoConstraints.facingMode = { ideal: 'environment' };
      }
    }

    stream = await navigator.mediaDevices.getUserMedia({
      video: videoConstraints,
      audio: false
    });

    cam.srcObject = stream;
    await cam.play();


    // Size canvases to the actual video frame for pixel-accurate reads
    const vw = cam.videoWidth || 800;
    const vh = cam.videoHeight || 480;
    capture.width = vw; capture.height = vh;

    // Match overlay to the element’s display size
    // Set overlay to fixed 400x400 size for consistent display
    overlay.width = 400 * devicePixelRatio;
    overlay.height = 400 * devicePixelRatio;

    isScanning = true;
    
    // Show camera preview when scanning starts
    if (typeof showCameraPreview === 'function') {
      showCameraPreview();
    }
    
    scanLoop();
  } catch (err) {
    console.error('Error starting camera:', err);
    isScanning = false;
  }
}

function stop() {
  if (rafId) cancelAnimationFrame(rafId);
  rafId = null;

  if (stream) {
    stream.getTracks().forEach(t => t.stop());
    stream = null;
  }
  
  isScanning = false;

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

// Event listeners for camera selection
cameraList.addEventListener('click', function(e) {
  e.preventDefault();
  if (e.target.classList.contains('dropdown-item')) {
    const cameraId = e.target.dataset.camera;
    if (cameraId) {
      selectCamera(cameraId);
    }
  }
  
  // Handle refresh cameras button
  if (e.target.id === 'refreshCameras' || e.target.closest('#refreshCameras')) {
    if (isSafari()) {
      enumerateCamerasSafari();
    } else {
      enumerateCameras();
    }
  }
});

// Manual dropdown toggle for better compatibility
cameraDropdown.addEventListener('click', function(e) {
  e.preventDefault();
  console.log('Dropdown clicked');
  const dropdownMenu = this.nextElementSibling;
  if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
    dropdownMenu.classList.toggle('show');
    console.log('Dropdown toggled, show class:', dropdownMenu.classList.contains('show'));
  }
});

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
  if (!cameraDropdown.contains(e.target) && !cameraList.contains(e.target)) {
    cameraList.classList.remove('show');
  }
});



// Initialize camera enumeration when page loads
document.addEventListener('DOMContentLoaded', function() {
  // Initialize Bootstrap dropdown
  if (typeof $ !== 'undefined' && $.fn.dropdown) {
    $('#cameraDropdown').dropdown();
  }
  
  // Set default camera selection
  selectedCameraId = 'default';
  
  // Use Safari-specific enumeration if detected
  if (isSafari()) {
    enumerateCamerasSafari();
  } else {
    // Standard enumeration for other browsers
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function(stream) {
        // Stop the temporary stream
        stream.getTracks().forEach(track => track.stop());
        // Now enumerate cameras
        enumerateCameras();
      })
      .catch(function(error) {
        console.log('Camera permission not granted:', error);
        // Still try to enumerate (might work on some browsers)
        enumerateCameras();
      });
  }
});

// Optional: auto-start if permissions were previously granted
if (navigator.permissions?.query) {
  navigator.permissions.query({ name: 'camera' }).then(p => {
    if (p.state === 'granted') {
      enumerateCameras();
    }
  }).catch(() => { });
}