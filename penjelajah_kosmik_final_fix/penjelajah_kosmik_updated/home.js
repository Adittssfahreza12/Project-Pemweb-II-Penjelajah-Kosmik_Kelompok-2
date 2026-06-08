function generateStars() {
  const container = document.getElementById('heroStars');
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

const style = document.createElement('style');
style.textContent = `
  @keyframes twinkle {
    from { opacity: 0.2; transform: scale(1); }
    to   { opacity: 0.9; transform: scale(1.3); }
  }
`;
document.head.appendChild(style);

generateStars();