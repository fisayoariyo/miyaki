(function () {
	'use strict';

	var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function revealOnScroll() {
		var targets = document.querySelectorAll('.reveal, .reveal-stagger');

		if (!targets.length) {
			return;
		}

		if (reduced) {
			targets.forEach(function (el) {
				el.classList.add('is-visible');
			});
			return;
		}

		var observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-visible');
						observer.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
		);

		targets.forEach(function (el) {
			observer.observe(el);
		});
	}

	function headerScroll() {
		var header = document.querySelector('.site-header');
		if (!header) {
			return;
		}

		var onScroll = function () {
			header.classList.toggle('is-scrolled', window.scrollY > 48);
		};

		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	function heroEntrance() {
		if (reduced) {
			document.documentElement.classList.add('hero-ready');
			return;
		}

		window.requestAnimationFrame(function () {
			document.documentElement.classList.add('hero-ready');
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		revealOnScroll();
		headerScroll();
		heroEntrance();
	});
})();
