/* ============================================================
   NexaVault — Main JavaScript
   Interactivity, animations & dynamic features
============================================================ */

'use strict';

/* ---- DOM Ready ---- */
document.addEventListener('DOMContentLoaded', () => {
  initNavbar();
  initMobileMenu();
  initAOS();
  initCounters();
  initBackToTop();
  initEmailForm();
  initPriceAnimation();
  initHoverEffects();
  console.log('%c⚡ NexaVault Loaded', 'color:#3B82F6; font-size:14px; font-weight:bold;');
});


/* ============================================================
   NAVBAR — Scroll effect + Active link highlighting
============================================================ */
function initNavbar() {
  const navbar = document.getElementById('navbar');
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-links a');

  // Scroll → add .scrolled class
  window.addEventListener('scroll', () => {
    if (window.scrollY > 60) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
    updateActiveLink();
  });

  // Active nav link based on scroll position
  function updateActiveLink() {
    let currentSection = '';
    sections.forEach(sec => {
      const sectionTop = sec.offsetTop - 100;
      if (window.scrollY >= sectionTop) {
        currentSection = sec.getAttribute('id');
      }
    });
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === '#' + currentSection) {
        link.classList.add('active');
      }
    });
  }
}


/* ============================================================
   MOBILE MENU
============================================================ */
function initMobileMenu() {
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');
  let menuOpen = false;

  hamburger.addEventListener('click', () => {
    menuOpen = !menuOpen;
    mobileMenu.classList.toggle('open', menuOpen);
    // Animate hamburger lines
    const spans = hamburger.querySelectorAll('span');
    if (menuOpen) {
      spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
      spans[1].style.opacity = '0';
      spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
    } else {
      resetHamburger(spans);
    }
  });

  // Close on backdrop click
  document.addEventListener('click', (e) => {
    if (menuOpen && !mobileMenu.contains(e.target) && !hamburger.contains(e.target)) {
      closeMobile();
    }
  });

  function resetHamburger(spans) {
    spans[0].style.transform = '';
    spans[1].style.opacity = '';
    spans[2].style.transform = '';
  }
}

// Global close function (used in HTML onclick)
window.closeMobile = function () {
  const mobileMenu = document.getElementById('mobileMenu');
  const hamburger = document.getElementById('hamburger');
  mobileMenu.classList.remove('open');
  const spans = hamburger.querySelectorAll('span');
  spans[0].style.transform = '';
  spans[1].style.opacity = '';
  spans[2].style.transform = '';
};


/* ============================================================
   AOS — Animate On Scroll (lightweight custom implementation)
============================================================ */
function initAOS() {
  const elements = document.querySelectorAll('[data-aos]');
  if (!elements.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        // Stagger delay for sibling elements
        const parent = entry.target.parentElement;
        const siblings = parent.querySelectorAll('[data-aos]');
        let index = 0;
        siblings.forEach((el, idx) => {
          if (el === entry.target) index = idx;
        });

        setTimeout(() => {
          entry.target.classList.add('aos-visible');
        }, index * 80);

        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: '0px 0px -60px 0px'
  });

  elements.forEach(el => observer.observe(el));
}


/* ============================================================
   COUNTERS — Animated number counting in hero stats
============================================================ */
function initCounters() {
  const counters = document.querySelectorAll('[data-target]');
  if (!counters.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(counter => observer.observe(counter));

  function animateCounter(el) {
    const target = parseInt(el.getAttribute('data-target'), 10);
    const duration = 1800;
    const stepTime = 16;
    const steps = duration / stepTime;
    let current = 0;

    const timer = setInterval(() => {
      current += target / steps;
      if (current >= target) {
        current = target;
        clearInterval(timer);
      }
      el.textContent = Math.floor(current);
    }, stepTime);
  }
}


/* ============================================================
   BACK TO TOP
============================================================ */
function initBackToTop() {
  const btn = document.getElementById('backToTop');
  if (!btn) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
      btn.classList.add('visible');
    } else {
      btn.classList.remove('visible');
    }
  });

  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}


/* ============================================================
   EMAIL CTA FORM — Interactive submit
============================================================ */
function initEmailForm() {
  const form = document.querySelector('.email-form');
  if (!form) return;

  const input = form.querySelector('.email-input');
  const btn = form.querySelector('.btn');

  btn.addEventListener('click', () => {
    const email = input.value.trim();
    if (!email || !isValidEmail(email)) {
      shakeInput(input);
      showTooltip(input, 'Please enter a valid email address');
      return;
    }
    // Success state
    btn.textContent = '✓ Welcome to NexaVault!';
    btn.style.background = 'linear-gradient(135deg, #065F46, #10B981)';
    btn.style.boxShadow = '0 4px 20px rgba(16,185,129,0.35)';
    input.disabled = true;
    input.value = email;
    input.style.opacity = '0.6';
    confettiEffect(btn);
  });

  input.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') btn.click();
  });

  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function shakeInput(el) {
    el.style.transition = 'transform 0.1s';
    el.style.borderColor = '#F87171';
    let count = 0;
    const interval = setInterval(() => {
      el.style.transform = count % 2 === 0 ? 'translateX(-4px)' : 'translateX(4px)';
      count++;
      if (count >= 6) {
        clearInterval(interval);
        el.style.transform = '';
        setTimeout(() => {
          el.style.borderColor = '';
          el.style.transition = '';
        }, 500);
      }
    }, 60);
  }

  function showTooltip(el, message) {
    const existing = document.querySelector('.form-tooltip');
    if (existing) existing.remove();

    const tooltip = document.createElement('div');
    tooltip.className = 'form-tooltip';
    tooltip.textContent = message;
    tooltip.style.cssText = `
      position: absolute;
      background: #1E3A8A;
      color: #93C5FD;
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 0.78rem;
      border: 1px solid rgba(59,130,246,0.3);
      pointer-events: none;
      z-index: 100;
      white-space: nowrap;
    `;

    const rect = el.getBoundingClientRect();
    tooltip.style.top = (rect.bottom + window.scrollY + 8) + 'px';
    tooltip.style.left = rect.left + 'px';
    document.body.appendChild(tooltip);

    setTimeout(() => tooltip.remove(), 2500);
  }
}


/* ============================================================
   CONFETTI — Quick celebration animation on CTA submit
============================================================ */
function confettiEffect(origin) {
  const colors = ['#3B82F6', '#60A5FA', '#22D3EE', '#FFFFFF', '#A78BFA'];
  const rect = origin.getBoundingClientRect();
  const cx = rect.left + rect.width / 2;
  const cy = rect.top + rect.height / 2 + window.scrollY;

  for (let i = 0; i < 30; i++) {
    const particle = document.createElement('div');
    particle.style.cssText = `
      position: absolute;
      width: ${Math.random() * 6 + 4}px;
      height: ${Math.random() * 6 + 4}px;
      background: ${colors[Math.floor(Math.random() * colors.length)]};
      border-radius: ${Math.random() > 0.5 ? '50%' : '2px'};
      left: ${cx}px;
      top: ${cy}px;
      pointer-events: none;
      z-index: 9999;
    `;
    document.body.appendChild(particle);

    const angle = Math.random() * Math.PI * 2;
    const velocity = Math.random() * 120 + 60;
    const vx = Math.cos(angle) * velocity;
    const vy = Math.sin(angle) * velocity - 80;
    const duration = Math.random() * 800 + 600;

    let startTime = null;

    function animate(time) {
      if (!startTime) startTime = time;
      const elapsed = time - startTime;
      const progress = elapsed / duration;

      if (progress >= 1) {
        particle.remove();
        return;
      }

      const x = cx + vx * progress;
      const y = cy + vy * progress + 150 * progress * progress;
      const opacity = 1 - progress;

      particle.style.left = x + 'px';
      particle.style.top = y + 'px';
      particle.style.opacity = opacity;
      particle.style.transform = `rotate(${progress * 360}deg)`;

      requestAnimationFrame(animate);
    }

    requestAnimationFrame(animate);
  }
}


/* ============================================================
   LIVE PRICE ANIMATION — Simulates live ticker price updates
============================================================ */
function initPriceAnimation() {
  const tickerItems = document.querySelectorAll('.ticker-item');
  if (!tickerItems.length) return;

  const cryptoData = [
    { name: 'BTC', price: 67450, change: 2.8 },
    { name: 'ETH', price: 3890,  change: 1.5 },
    { name: 'SOL', price: 185,   change: -0.6 },
    { name: 'BNB', price: 610,   change: 3.1 },
    { name: 'XRP', price: 0.72,  change: 4.2 },
    { name: 'ADA', price: 0.58,  change: -1.3 },
    { name: 'AVAX', price: 42.10, change: 5.6 },
    { name: 'MATIC', price: 1.04, change: 2.0 },
    { name: 'DOT', price: 8.90,  change: -0.9 },
    { name: 'LINK', price: 18.70, change: 1.8 },
  ];

  // Simulate small price fluctuations every 5s
  setInterval(() => {
    cryptoData.forEach(crypto => {
      const fluctuation = (Math.random() - 0.48) * 0.3;
      crypto.price = Math.max(0.01, crypto.price * (1 + fluctuation / 100));
      crypto.change += (Math.random() - 0.5) * 0.2;
      crypto.change = Math.max(-15, Math.min(15, crypto.change));
    });

    // Update ticker DOM (first 10 items)
    tickerItems.forEach((item, i) => {
      const dataIndex = i % cryptoData.length;
      const crypto = cryptoData[dataIndex];
      if (!crypto) return;

      const priceEl = item.querySelector('.t-price');
      const changeEl = item.querySelector('.t-change');
      if (!priceEl || !changeEl) return;

      // Format price
      let formattedPrice;
      if (crypto.price >= 1000) {
        formattedPrice = '$' + crypto.price.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      } else if (crypto.price >= 1) {
        formattedPrice = '$' + crypto.price.toFixed(2);
      } else {
        formattedPrice = '$' + crypto.price.toFixed(4);
      }

      priceEl.textContent = formattedPrice;

      const changeSign = crypto.change >= 0 ? '+' : '';
      changeEl.textContent = changeSign + crypto.change.toFixed(1) + '%';
      changeEl.className = 't-change ' + (crypto.change >= 0 ? 'pos' : 'neg');
    });
  }, 5000);
}


/* ============================================================
   HOVER EFFECTS — Feature/pricing card glow on hover
============================================================ */
function initHoverEffects() {
  // Magnetic button effect on primary CTAs
  const buttons = document.querySelectorAll('.btn-primary, .btn-gold');
  buttons.forEach(btn => {
    btn.addEventListener('mousemove', (e) => {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;
      btn.style.transform = `translate(${x * 0.08}px, ${y * 0.08}px) translateY(-2px)`;
    });
    btn.addEventListener('mouseleave', () => {
      btn.style.transform = '';
    });
  });

  // Feature card particle trail
  const featureCards = document.querySelectorAll('.feature-card, .testi-card');
  featureCards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = ((e.clientX - rect.left) / rect.width) * 100;
      const y = ((e.clientY - rect.top) / rect.height) * 100;
      card.style.background = `
        radial-gradient(circle at ${x}% ${y}%, rgba(59,130,246,0.12) 0%, transparent 50%),
        var(--card-bg)
      `;
    });
    card.addEventListener('mouseleave', () => {
      card.style.background = '';
    });
  });
}


/* ============================================================
   SMOOTH ANCHOR SCROLLING with offset for fixed navbar
============================================================ */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', (e) => {
    const target = anchor.getAttribute('href');
    if (target === '#') return;
    const el = document.querySelector(target);
    if (!el) return;
    e.preventDefault();
    const navHeight = document.getElementById('navbar')?.offsetHeight || 80;
    const top = el.getBoundingClientRect().top + window.scrollY - navHeight - 20;
    window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
  });
});


/* ============================================================
   SPARKLINE — Animate the mini chart line in phone mockup
============================================================ */
function animateMiniChart() {
  const path = document.querySelector('.mini-chart path:last-child');
  const areaPath = document.querySelector('.mini-chart path:first-child');
  if (!path) return;

  // Different data points for animation
  const dataSets = [
    "M0,55 L20,45 L40,50 L60,35 L80,38 L100,25 L120,28 L140,15 L160,18 L180,8 L200,5",
    "M0,45 L20,50 L40,38 L60,42 L80,28 L100,30 L120,18 L140,22 L160,10 L180,14 L200,3",
    "M0,50 L20,40 L40,45 L60,30 L80,33 L100,20 L120,23 L140,12 L160,15 L180,6 L200,8",
  ];

  const areaSets = [
    "M0,55 L20,45 L40,50 L60,35 L80,38 L100,25 L120,28 L140,15 L160,18 L180,8 L200,5 L200,60 L0,60 Z",
    "M0,45 L20,50 L40,38 L60,42 L80,28 L100,30 L120,18 L140,22 L160,10 L180,14 L200,3 L200,60 L0,60 Z",
    "M0,50 L20,40 L40,45 L60,30 L80,33 L100,20 L120,23 L140,12 L160,15 L180,6 L200,8 L200,60 L0,60 Z",
  ];

  let current = 0;
  setInterval(() => {
    current = (current + 1) % dataSets.length;
    path.setAttribute('d', dataSets[current]);
    if (areaPath) areaPath.setAttribute('d', areaSets[current]);
  }, 3000);
}

// Small delay before starting chart animation
setTimeout(animateMiniChart, 1000);


/* ============================================================
   COIN PRICE UPDATES — phone mockup prices
============================================================ */
(function () {
  const coinRows = document.querySelectorAll('.coin-row');
  const mockPrices = [
    { price: 67450, change: 3.4 },
    { price: 3890,  change: 1.9 },
    { price: 185,   change: -0.7 },
  ];

  setInterval(() => {
    coinRows.forEach((row, i) => {
      if (!mockPrices[i]) return;
      const p = mockPrices[i];
      p.change += (Math.random() - 0.5) * 0.3;
      p.change = Math.max(-8, Math.min(8, p.change));
      const changeEl = row.querySelector('.coin-price');
      if (changeEl) {
        const sign = p.change >= 0 ? '+' : '';
        changeEl.textContent = sign + p.change.toFixed(1) + '%';
        changeEl.className = 'coin-price ' + (p.change >= 0 ? 'positive' : 'negative');
      }
    });
  }, 3500);
})();


/* ============================================================
   BALANCE ANIMATION — phone mockup balance counter
============================================================ */
(function () {
  const balanceEl = document.querySelector('.balance-amount');
  const changeEl = document.querySelector('.balance-change');
  if (!balanceEl) return;

  let balance = 84320.50;
  let change = 2140.30;

  setInterval(() => {
    const delta = (Math.random() - 0.48) * 80;
    balance += delta;
    change += delta;

    balanceEl.textContent = '$' + balance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    const sign = change >= 0 ? '+' : '';
    const pct = ((Math.abs(change) / (balance - change)) * 100).toFixed(1);
    if (changeEl) {
      changeEl.textContent = sign + '$' + change.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ' (' + (change >= 0 ? '+' : '') + pct + '%) today';
      changeEl.className = 'balance-change ' + (change >= 0 ? 'positive' : 'negative');
    }
  }, 4000);
})();
