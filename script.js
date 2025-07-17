document.addEventListener('DOMContentLoaded', function() {
  const toggle = document.getElementById('modeToggle');
  const body = document.body;
  
  // Check for saved theme preference or use preferred color scheme
  const savedTheme = localStorage.getItem('theme') || 
                    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
  
  // Apply the saved theme
  if (savedTheme === 'dark') {
    body.classList.add('dark-mode');
    body.classList.remove('light-mode');
    toggle.innerHTML = '💡 Light Mode'; // Changed to light mode icon for dark theme
  } else {
    body.classList.add('light-mode');
    body.classList.remove('dark-mode');
    toggle.innerHTML = '🌙 Dark Mode'; // Changed to dark mode icon for light theme
  }
  
  // Toggle theme on button click
  toggle.addEventListener('click', () => {
    if (body.classList.contains('dark-mode')) {
      body.classList.remove('dark-mode');
      body.classList.add('light-mode');
      localStorage.setItem('theme', 'light');
      toggle.innerHTML = '🌙 Dark Mode'; // Changed to dark mode icon
    } else {
      body.classList.remove('light-mode');
      body.classList.add('dark-mode');
      localStorage.setItem('theme', 'dark');
      toggle.innerHTML = '💡 Light Mode'; // Changed to light mode icon
    }
  });
  
  // Add floating particles to background
  createParticles();
  
  // Email validation on form submit
  const forms = document.querySelectorAll('form');
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      const emailInput = form.querySelector('input[type="email"]');
      if (emailInput) {
        emailInput.value = emailInput.value.trim().toLowerCase();
      }
    });
  });

  // Auto-close alerts after 5 seconds
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      alert.classList.add('fade');
      setTimeout(() => alert.remove(), 150);
    }, 5000);
  });
  
  // Enhance select dropdowns
  const selects = document.querySelectorAll('select');
  selects.forEach(select => {
    select.addEventListener('focus', function() {
      this.style.boxShadow = '0 0 10px var(--neon-blue)';
    });
    select.addEventListener('blur', function() {
      this.style.boxShadow = 'none';
    });
  });
});

function createParticles() {
  const particlesContainer = document.createElement('div');
  particlesContainer.className = 'particles';
  document.querySelector('.jdm-background').appendChild(particlesContainer);
  
  const particleCount = 50;
  
  for (let i = 0; i < particleCount; i++) {
    const particle = document.createElement('div');
    particle.className = 'particle';
    // Random properties
    const size = Math.random() * 5 + 2;
    const posX = Math.random() * 100;
    const posY = Math.random() * 100;
    const delay = Math.random() * 10;
    const duration = Math.random() * 20 + 10;
    const color = `hsl(${Math.random() * 60 + 200}, 100%, 50%)`; // Fixed template literal
    particle.style.width = `${size}px`;
    particle.style.height = `${size}px`;
    particle.style.left = `${posX}%`;
    particle.style.top = `${posY}%`;
    particle.style.animationDelay = `${delay}s`;
    particle.style.animationDuration = `${duration}s`;
    particle.style.backgroundColor = color;
    particlesContainer.appendChild(particle);
  }
  
  // Add CSS for particles
  const style = document.createElement('style');
  style.textContent = `
    .particles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 1;
    }
    
    .particle {
      position: absolute;
      border-radius: 50%;
      opacity: 0.6;
      animation: float linear infinite;
    }
    
    @keyframes float {
      0% {
        transform: translateY(0) translateX(0);
        opacity: 0.6;
      }
      50% {
        opacity: 0.9;
      }
      100% {
        transform: translateY(-100vh) translateX(20px);
        opacity: 0;
      }
    }
  `;
  document.head.appendChild(style);
}