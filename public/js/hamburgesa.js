document.addEventListener('DOMContentLoaded', function() {
  // Seleccionar elementos del DOM
  const menuToggle = document.querySelector('.menu-toggle');
  const navLinks = document.querySelector('.acomp-header-nav-links');
  
  // Función para alternar el menú móvil
  function toggleMenu() {
    navLinks.classList.toggle('active');
    
    // Cambiar el icono del menú hamburguesa a una X cuando está abierto
    if (navLinks.classList.contains('active')) {
      menuToggle.textContent = '✕';
    } else {
      menuToggle.textContent = '☰';
    }
  }
  
  // Event listener para el botón del menú hamburguesa
  menuToggle.addEventListener('click', toggleMenu);
  
  // Cerrar el menú cuando se hace clic en un enlace (útil para móviles)
  const navItems = document.querySelectorAll('.acomp-header-nav-links a');
  navItems.forEach(item => {
    item.addEventListener('click', () => {
      if (window.innerWidth <= 768) {
        toggleMenu();
      }
    });
  });
  
  // Cerrar el menú al hacer clic fuera de él
  document.addEventListener('click', function(event) {
    if (window.innerWidth <= 768 && 
        !event.target.closest('.menu-toggle') && 
        !event.target.closest('.acomp-header-nav-links') &&
        navLinks.classList.contains('active')) {
      toggleMenu();
    }
  });
  
  // Cambiar el header al hacer scroll
  const header = document.querySelector('.acomp-header');
  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
      header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
    } else {
      header.style.boxShadow = 'none';
    }
  });
});