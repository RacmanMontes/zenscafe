import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;

document.addEventListener('alpine:init', () => {
    Alpine.data('floatingActionButton', () => ({
        x: 0,
        y: 0,
        dragging: false,
        moved: false,
        startClientX: 0,
        startClientY: 0,
        offsetX: 0,
        offsetY: 0,

        init() {
            const saved = window.localStorage.getItem('zenscafe-fab-position');
            if (saved) {
                const pos = JSON.parse(saved);
                this.x = Number(pos.x) || 0;
                this.y = Number(pos.y) || 0;
            }
            this.boundMove = this.move.bind(this);
            this.boundEnd = this.end.bind(this);
        },

        get style() {
            return `transform: translate3d(${this.x}px, ${this.y}px, 0)`;
        },

        start(e) {
            const point = e.touches ? e.touches[0] : e;
            this.dragging = true;
            this.moved = false;
            this.startClientX = point.clientX;
            this.startClientY = point.clientY;
            this.offsetX = this.x;
            this.offsetY = this.y;

            document.addEventListener('mousemove', this.boundMove);
            document.addEventListener('mouseup', this.boundEnd);
            document.addEventListener('touchmove', this.boundMove, { passive: false });
            document.addEventListener('touchend', this.boundEnd);
        },

        move(e) {
            if (!this.dragging) return;
            e.preventDefault();
            const point = e.touches ? e.touches[0] : e;
            this.x = this.offsetX + (point.clientX - this.startClientX);
            this.y = this.offsetY + (point.clientY - this.startClientY);

            if (Math.abs(point.clientX - this.startClientX) > 3 || Math.abs(point.clientY - this.startClientY) > 3) {
                this.moved = true;
            }
        },

        end() {
            if (!this.dragging) return;
            this.dragging = false;
            window.localStorage.setItem('zenscafe-fab-position', JSON.stringify({ x: this.x, y: this.y }));
            document.removeEventListener('mousemove', this.boundMove);
            document.removeEventListener('mouseup', this.boundEnd);
            document.removeEventListener('touchmove', this.boundMove);
            document.removeEventListener('touchend', this.boundEnd);
        },

        onMouseDown(e) {
            if (e.button !== 0) return;
            this.start(e);
        },

        onTouchStart(e) {
            this.start(e);
        },

        onClick(e) {
            if (this.moved || this.dragging) {
                e.preventDefault();
                e.stopPropagation();
            }
        },
    }));

    Alpine.data('toastNotifications', (flash = {}, headings = {}) => ({
        init() {
            if (flash.success) this.showToast('success', headings.success ?? 'Success', flash.success);
            if (flash.error) this.showToast('danger', headings.error ?? 'Error', flash.error);
        },

        showToast(variant, title, text) {
            requestAnimationFrame(() => {
                document.dispatchEvent(new CustomEvent('toast-show', {
                    detail: {
                        slots: { heading: title, text },
                        dataset: { variant },
                        duration: 5000,
                    },
                }));
            });
        },
    }));
});