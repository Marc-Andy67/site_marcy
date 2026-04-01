const canvas = document.getElementById('starry-night');
const ctx = canvas.getContext('2d');

let width, height;


function setDimensions() {
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
}
setDimensions();

function resize() {
    setDimensions();

    // Re-distribute stars to cover the new area
    if (typeof stars !== 'undefined') {
        stars.forEach(s => s.reset());
    }
}
window.addEventListener('resize', resize);

// --- Stars Removed per request to use CSS background ---
// class Star { ... } created removed

// const stars = ... removed

// --- Shooting Stars ---
class ShootingStar {
    constructor() {
        this.reset();
    }

    reset() {
        this.x = Math.random() * width;
        this.y = Math.random() * height * 0.4; // Start in top part
        this.len = Math.random() * 80 + 10;
        this.speed = Math.random() * 10 + 6;
        this.size = Math.random() * 1 + 0.1;
        this.active = false;
        // Wait time between shots
        this.waitTime = new Date().getTime() + Math.random() * 3000 + 2000;
    }

    update() {
        if (this.active) {
            this.x -= this.speed;
            this.y += this.speed * 0.6; // Down-left trajectory
            if (this.x < 0 || this.y >= height) {
                this.active = false;
                this.reset(); // Plan next shot
            }
        } else {
            if (this.waitTime < new Date().getTime()) {
                this.active = true;
                // Start position
                this.x = Math.random() * width + 200;
                this.y = Math.random() * height * 0.2;
            }
        }
    }

    draw() {
        if (!this.active) return;
        ctx.save();
        ctx.strokeStyle = 'rgba(255, 255, 255, ' + Math.random() + ')';
        ctx.lineWidth = this.size;
        ctx.beginPath();
        ctx.moveTo(this.x, this.y);
        ctx.lineTo(this.x + this.len, this.y - this.len * 0.6);
        ctx.shadowBlur = 10;
        ctx.shadowColor = 'white';
        ctx.stroke();
        ctx.restore();
    }
}

const shootingStars = Array.from({ length: 3 }, () => new ShootingStar());


// --- Moon ---
function drawMoon() {
    const moonX = width * 0.85;
    const moonY = height * 0.15;
    const radius = 50;

    // Glow
    const gradient = ctx.createRadialGradient(moonX, moonY, radius * 0.8, moonX, moonY, radius * 4);
    gradient.addColorStop(0, 'rgba(255, 255, 255, 0.4)');
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
    ctx.save();
    ctx.fillStyle = gradient;
    ctx.beginPath();
    ctx.arc(moonX, moonY, radius * 4, 0, Math.PI * 2);
    ctx.fill();
    ctx.restore();

    // Crescent Moon Rendering
    ctx.save();
    // 1. Draw full circle
    ctx.beginPath();
    ctx.arc(moonX, moonY, radius, 0, Math.PI * 2);
    ctx.fillStyle = '#f0f0f0';
    ctx.shadowBlur = 15;
    ctx.shadowColor = '#fff';
    ctx.fill();

    // 2. Cut out shadow to make crescent (destination-out)
    ctx.globalCompositeOperation = 'destination-out';
    ctx.beginPath();
    ctx.arc(moonX - 25, moonY - 10, radius * 0.95, 0, Math.PI * 2);
    ctx.fillStyle = 'black'; // Color ignored, just alpha matters
    ctx.fill();
    ctx.restore();
}


function animate() {
    ctx.clearRect(0, 0, width, height);

    // Stars drawing loop removed

    // Draw Shooting Stars
    shootingStars.forEach(s => {
        s.update();
        s.draw();
    });

    // Draw Moon
    drawMoon();

    requestAnimationFrame(animate);
}

animate();
