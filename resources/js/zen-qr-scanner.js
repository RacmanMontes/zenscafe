import { Html5Qrcode } from 'html5-qrcode';

window.ZenQrScanner = {
    _scanner: null,

    start(containerId, onResult) {
        if (this._scanner) {
            return;
        }

        const scanner = new Html5Qrcode(containerId);
        this._scanner = scanner;

        scanner.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 220, height: 220 } },
            (decodedText) => {
                this.stop();
                onResult(decodedText);
            },
            () => {},
        );
    },

    stop() {
        if (!this._scanner) {
            return;
        }

        const scanner = this._scanner;
        this._scanner = null;

        scanner.stop()
            .catch(() => {})
            .finally(() => {
                scanner.clear();
            });
    },
};