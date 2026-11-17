(function () {
	'use strict';

	var STORAGE_KEY = 'miyaki-theme';
	var root = document.documentElement;
	var toggle = document.querySelector('[data-theme-toggle]');

	function getPreferred() {
		try {
			var stored = localStorage.getItem(STORAGE_KEY);
			if (stored === 'light' || stored === 'dark') {
				return stored;
			}
		} catch (e) {}

		return 'light';
	}

	function applyTheme(theme) {
		root.setAttribute('data-theme', theme);
		try {
			localStorage.setItem(STORAGE_KEY, theme);
		} catch (e) {}
	}

	applyTheme(getPreferred());

	if (toggle) {
		toggle.addEventListener('click', function () {
			var current = root.getAttribute('data-theme') || 'light';
			applyTheme(current === 'dark' ? 'light' : 'dark');
		});
	}
})();
