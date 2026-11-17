(function () {
	'use strict';

	var modal = document.getElementById('miyaki-quick-view');
	if (!modal || typeof miyakiQuickView === 'undefined') {
		return;
	}

	var content = modal.querySelector('.quick-view-content');
	var closeEls = modal.querySelectorAll('[data-quick-view-close]');

	function openModal() {
		modal.hidden = false;
		modal.setAttribute('aria-hidden', 'false');
		document.body.style.overflow = 'hidden';
	}

	function closeModal() {
		modal.hidden = true;
		modal.setAttribute('aria-hidden', 'true');
		document.body.style.overflow = '';
		content.innerHTML = '';
	}

	function loadProduct(productId) {
		content.innerHTML = '<p>' + miyakiQuickView.i18n.loading + '</p>';
		openModal();

		var body = new FormData();
		body.append('action', 'miyaki_quick_view');
		body.append('nonce', miyakiQuickView.nonce);
		body.append('product_id', productId);

		fetch(miyakiQuickView.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: body,
		})
			.then(function (res) {
				return res.json();
			})
			.then(function (data) {
				if (data.success && data.data && data.data.html) {
					content.innerHTML = data.data.html;
				} else {
					content.innerHTML = '<p>' + miyakiQuickView.i18n.error + '</p>';
				}
			})
			.catch(function () {
				content.innerHTML = '<p>' + miyakiQuickView.i18n.error + '</p>';
			});
	}

	document.addEventListener('click', function (event) {
		var trigger = event.target.closest('.quick-view-trigger');
		if (trigger) {
			event.preventDefault();
			loadProduct(trigger.getAttribute('data-product-id'));
		}
	});

	closeEls.forEach(function (el) {
		el.addEventListener('click', closeModal);
	});

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape' && !modal.hidden) {
			closeModal();
		}
	});
})();
