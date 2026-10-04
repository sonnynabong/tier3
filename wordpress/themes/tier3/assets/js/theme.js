'use strict';

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

function enterHero() {
  if (reducedMotion.matches || typeof Element.prototype.animate !== 'function') return;
  const timing = { duration: 680, easing: 'cubic-bezier(.16, 1, .3, 1)' };
  document.querySelectorAll('.hero-line').forEach((line, index) => {
    line.animate([
      { transform: 'translateY(24px)', opacity: .3, clipPath: 'inset(0 0 24% 0)' },
      { transform: 'translateY(0)', opacity: 1, clipPath: 'inset(0 0 0 0)' }
    ], { ...timing, delay: index * 65, fill: 'backwards' });
  });
  const bottle = document.querySelector('.bottle');
  if (bottle) {
    bottle.animate([
      { transform: 'translateY(35px) rotate(0deg)', opacity: .4 },
      { transform: 'translateY(0) rotate(-7deg)', opacity: 1 }
    ], { ...timing, delay: 60, fill: 'backwards' });
  }
  const description = document.querySelector('.hero-description');
  if (description) {
    description.animate([
      { opacity: .3, transform: 'translateY(8px)' }, { opacity: 1, transform: 'translateY(0)' }
    ], { ...timing, duration: 500, delay: 140, fill: 'backwards' });
  }
}
enterHero();

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
        : kind === 'quote'
          ? [{ opacity: .72 }, { opacity: 1 }]
          : [{ opacity: .35, transform: 'translateY(16px)' }, { opacity: 1, transform: 'translateY(0)' }];
      target.animate(motion, {
        duration: kind === 'quote' ? 520 : 650,
        delay: kind === 'step' ? Math.min(index * 55, 165) : 0,
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
