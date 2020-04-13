<?php

namespace Tests\Mandelbrot;

use Exception;
use Mandelbrot\Image;

class MandelbrotImageShould extends BaseTestClass {
    /**
     * @test
     * @throws Exception
     */
    public function generate_a_mandelbrot_image_with_same_width_and_height() {
        https://github.com/josecelano/php-mandelbrot-arbitrary-precision/issues/3
        ini_set('memory_limit', '2048M');

        $resolution = 160;
        $image = new Image($resolution);

        $fileDir = __DIR__ . '/../output';
        $fileName = "/mandelbrot-{$resolution}x{$resolution}.png";
        $filePath = $fileDir . $fileName;

        if (is_file($filePath)) {
            unlink($filePath);
        }

        $image->save($filePath);

        $this->assertFileExists($filePath);
    }
}