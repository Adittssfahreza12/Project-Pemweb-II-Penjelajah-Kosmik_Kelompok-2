const hamburger = document.getElementById('navHamburger');
const navLinks  = document.querySelector('.navbar-links');

hamburger.addEventListener('click', () => {
  navLinks.classList.toggle('open');
});