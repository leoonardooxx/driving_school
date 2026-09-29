import './bootstrap';

const navbar = document.querySelector('[data-navbar]');

if (navbar) {
    const center = navbar.querySelector('[data-nav-center]');
    const all = navbar.querySelector('[data-nav-all]');
    const items = [...center.querySelectorAll('[data-nav-item]')];

    const fits = () => {
        const visible = [...items, all].filter((item) => !item.hidden);
        const gap = parseFloat(getComputedStyle(center).columnGap) || 0;
        const width = visible.reduce((sum, item) => sum + item.offsetWidth, 0) + gap * Math.max(visible.length - 1, 0);
        return width <= center.clientWidth;
    };

    const layout = () => {
        items.forEach((item) => (item.hidden = false));
        for (let i = items.length - 1; i >= 0 && !fits(); i--) {
            if (!items[i].hasAttribute('data-nav-active')) items[i].hidden = true;
        }
    };

    new ResizeObserver(layout).observe(navbar);
}
