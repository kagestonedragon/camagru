const topMenuOpenButton = document.getElementById('js-menu-open');
const topMenuCloseButton = document.getElementById('js-menu-close');
const topMenu = document.getElementById('js-menu-fields');

topMenuOpenButton.addEventListener('click', function(e) {
    topMenu.classList.remove('nav-mobile__menu-closed');
    topMenu.classList.add('nav-mobile__menu-opened');
    topMenuOpenButton.style.display = 'none';
    topMenuCloseButton.style.display = 'block';
});

topMenuCloseButton.addEventListener('click', function(e) {
    topMenu.classList.remove('nav-mobile__menu-opened');
    topMenu.classList.add('nav-mobile__menu-closed');
    topMenuOpenButton.style.display = 'block';
    topMenuCloseButton.style.display = 'none';
});