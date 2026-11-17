(function () {
	'use strict';

	var toggle = document.querySelector('[data-menu-toggle]');
	var mobileMenu = document.getElementById('mobile-menu');

	if (toggle && mobileMenu) {
		toggle.addEventListener('click', function () {
			var open = mobileMenu.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			mobileMenu.hidden = !open;
		});
	}
})();
