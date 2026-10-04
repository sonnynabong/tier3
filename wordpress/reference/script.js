'use strict';

// Navigation is expanded in the unenhanced document, so every link remains usable.
const menuButton = document.querySelector('.menu-toggle');
const navigation = document.querySelector('#navigation');
const mobileViewport = window.matchMedia('(max-width: 800px)');
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

function closeMenu({ restoreFocus = false } = {}) {
  menuButton.setAttribute('aria-expanded', 'false');
  menuButton.querySelector('span').textContent = 'Menu';
  navigation.classList.remove('is-open');
  if (restoreFocus) menuButton.focus();
}

function syncNavigation() {
  closeMenu();
  menuButton.hidden = !mobileViewport.matches;
}

menuButton.addEventListener('click', () => {
  const open = menuButton.getAttribute('aria-expanded') !== 'true';
  menuButton.setAttribute('aria-expanded', String(open));
  menuButton.querySelector('span').textContent = open ? 'Close' : 'Menu';
  navigation.classList.toggle('is-open', open);
});
navigation.addEventListener('click', (event) => {
  if (event.target.closest('a')) closeMenu();
});
document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
    closeMenu({ restoreFocus: true });
  }
});
document.addEventListener('click', (event) => {
  if (!event.target.closest('.site-header')) closeMenu();
});
document.querySelector('.site-header').addEventListener('focusout', (event) => {
  if (event.relatedTarget && !event.currentTarget.contains(event.relatedTarget)) closeMenu();
});
mobileViewport.addEventListener('change', syncNavigation);
syncNavigation();
document.documentElement.classList.add('navigation-ready');

// One short editorial entrance; no content depends on the animation finishing.
function enterHero() {
  if (reducedMotion.matches || typeof Element.prototype.animate !== 'function') return;
  const timing = { duration: 680, easing: 'cubic-bezier(.16, 1, .3, 1)' };
  document.querySelectorAll('.hero-line').forEach((line, index) => {
    line.animate([
      { transform: 'translateY(24px)', opacity: .3, clipPath: 'inset(0 0 24% 0)' },
      { transform: 'translateY(0)', opacity: 1, clipPath: 'inset(0 0 0 0)' }
    ], { ...timing, delay: index * 65, fill: 'backwards' });
  });
  document.querySelector('.bottle').animate([
    { transform: 'translateY(35px) rotate(0deg)', opacity: .4 },
    { transform: 'translateY(0) rotate(-7deg)', opacity: 1 }
  ], { ...timing, delay: 60 });
  document.querySelector('.hero-description').animate([
    { opacity: .3, transform: 'translateY(8px)' }, { opacity: 1, transform: 'translateY(0)' }
  ], { ...timing, duration: 500, delay: 140, fill: 'backwards' });
}
enterHero();

// Observe the already-visible content: no hidden classes or blank fallback states.
let revealObserver;
function configureReveals() {
  revealObserver?.disconnect();
  if (reducedMotion.matches || !('IntersectionObserver' in window) || typeof Element.prototype.animate !== 'function') return;
  revealObserver = new IntersectionObserver((entries) => {
    const arriving = entries.filter((entry) => entry.isIntersecting);
    arriving.forEach(({ target }, index) => {
      const kind = target.dataset.reveal;
      const motion = kind === 'image'
        ? [{ opacity: .65, clipPath: 'inset(0 0 5% 0)' }, { opacity: 1, clipPath: 'inset(0 0 0 0)' }]
        : [{ opacity: .35, transform: `translateY(${kind === 'logo' ? 10 : 20}px)` }, { opacity: 1, transform: 'translateY(0)' }];
      target.animate(motion, {
        duration: kind === 'logo' ? 500 : 650,
        delay: kind === 'logo' || kind === 'step' ? Math.min(index * 55, 165) : 0,
        easing: 'cubic-bezier(.16, 1, .3, 1)',
        fill: 'backwards'
      });
      target.dataset.revealed = 'true';
      revealObserver.unobserve(target);
    });
  }, { threshold: .1 });
  document.querySelectorAll('[data-reveal]:not([data-revealed])').forEach((element) => revealObserver.observe(element));
}
configureReveals();
reducedMotion.addEventListener('change', () => {
  if (reducedMotion.matches) document.getAnimations().forEach((animation) => animation.cancel());
  configureReveals();
});
