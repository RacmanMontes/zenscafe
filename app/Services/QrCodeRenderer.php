<?php

namespace App\Services;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

final class QrCodeRenderer
{
    /**
     * Render a QR code as an SVG string.
     */
    public function render(string $data, int $size = 192, int $margin = 0): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle($size, $margin),
            new SvgImageBackEnd,
        );

        return (new Writer($renderer))->writeString($data);
    }
}
