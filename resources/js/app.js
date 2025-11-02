import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Relative time updater: updates any <time data-relative-time="ISO"> to human text
(() => {
	const selector = 'time[data-relative-time]';
	const rtf = new Intl.RelativeTimeFormat('id', { numeric: 'auto' });

	function formatRelative(date) {
		const now = new Date();
		const diffMs = date - now; // future negative, past negative value? We'll compute with units
		const diffSec = Math.round(diffMs / 1000);

		const units = [
			['year', 60 * 60 * 24 * 365],
			['month', 60 * 60 * 24 * 30],
			['week', 60 * 60 * 24 * 7],
			['day', 60 * 60 * 24],
			['hour', 60 * 60],
			['minute', 60],
			['second', 1],
		];

		const sec = Math.round((date.getTime() - now.getTime()) / 1000);
		for (const [unit, secondsInUnit] of units) {
			if (Math.abs(sec) >= secondsInUnit || unit === 'second') {
				const value = Math.round(sec / secondsInUnit);
				return rtf.format(value, unit);
			}
		}
	}

	function updateAll() {
		document.querySelectorAll(selector).forEach((el) => {
			const iso = el.getAttribute('data-relative-time');
			if (!iso) return;
			const d = new Date(iso);
			if (isNaN(d)) return;
			el.textContent = formatRelative(d);
			if (!el.getAttribute('title')) {
				el.setAttribute('title', d.toLocaleString('id-ID'));
			}
		});
	}

	// First paint and periodic refresh
	if (document.readyState !== 'loading') updateAll();
	else document.addEventListener('DOMContentLoaded', updateAll);
	setInterval(updateAll, 60 * 1000); // refresh every minute
})();
