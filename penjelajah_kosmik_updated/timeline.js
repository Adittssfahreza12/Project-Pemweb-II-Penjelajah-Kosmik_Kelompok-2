function initTimelineObserver() {
  const items = document.querySelectorAll('.timeline-item');
  if (items.length === 0) return;

  const observerOptions = {
    root: null,
    threshold: 0.15,
    rootMargin: "0px 0px -40px 0px"
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  items.forEach(item => observer.observe(item));
}

function generateTimelineStars() {
  const container = document.getElementById('starsContainer');
  if (!container) return;

  const count = 120;
  const fragment = document.createDocumentFragment();

  for (let i = 0; i < count; i++) {
    const star = document.createElement('div');
    const size = Math.random() * 2.5 + 0.5;

    star.style.cssText = `
      position: absolute;
      width: ${size}px;
      height: ${size}px;
      background: white;
      border-radius: 50%;
      top: ${Math.random() * 100}%;
      left: ${Math.random() * 100}%;
      opacity: ${Math.random() * 0.6 + 0.2};
      animation: twinkle ${Math.random() * 3 + 2}s ease-in-out infinite alternate;
      animation-delay: ${Math.random() * 3}s;
    `;

    fragment.appendChild(star);
  }

  container.appendChild(fragment);
}
const styleElement = document.createElement('style');
styleElement.textContent = `
  @keyframes twinkle {
    from { opacity: 0.2; transform: scale(1); }
    to   { opacity: 0.9; transform: scale(1.3); }
  }
`;
document.head.appendChild(styleElement);
document.addEventListener("DOMContentLoaded", () => {
  generateTimelineStars();
  initTimelineObserver();
});