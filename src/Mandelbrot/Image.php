<?php

namespace Mandelbrot;

use DomainException;
use Exception;

class Image {

    private int $resolution;
    private Fractal $fractal;
    /** @var resource|false */
    private $img;

    /**
     * Image constructor.
     * @param int $resolution
     */
    public function __construct(int $resolution) {
        if ($resolution < 1) {
            throw new DomainException('Invalid image resolution. It should be greater than 0');
        }
        $this->resolution = $resolution;
        $this->fractal = new Fractal($this->resolution);
        $this->img = false;
    }

    public function save(string $imagePath) {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->guardThatDirectoryExists($imagePath);

        $this->createImage();
        $this->renderImage();
        $this->saveImage($imagePath);
        $this->destroyImage();
    }

    private function createImage() {
        $this->img = imagecreatetruecolor($this->resolution, $this->resolution);
    }

    private function renderImage() {
        for ($row = 0; $row < $this->resolution; $row++) {
            $this->renderRow($row);
        }
    }

    private function renderRow(int $row) {
        $black = imagecolorallocate($this->img, 0, 0, 0);
        $white = imagecolorallocate($this->img, 255, 255, 255);

        for ($column = 0; $column < $this->resolution; $column++) {

            $colour = $white;

            if ($this->fractal->pixelBelongsToMandelbrotSet($row, $column)) {
                $colour = $black;
            }

            imagesetpixel($this->img, $column, $row, $colour);
        }
    }

    /**
     * @param string $imagePath
     * @throws Exception
     */
    private function guardThatDirectoryExists(string $imagePath) {
        if (!is_dir(dirname($imagePath))) {
            throw new Exception('Invalid directory path');
        }
    }

    /**
     * @param string $imagePath
     */
    private function saveImage(string $imagePath) {
        imagepng($this->img, $imagePath);
    }

    private function destroyImage() {
        imagedestroy($this->img);
        $this->img = false;
    }
}