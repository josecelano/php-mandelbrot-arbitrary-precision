<?php

namespace Mandelbrot;

use ArbitraryPrecisionComplex\Complex;
use ArbitraryPrecisionComplex\DecimalFactory;
use DomainException;

class Fractal {

    private int $resolution;

    /**
     * MandelbrotImage constructor.
     * @param int $resolution
     */
    public function __construct(int $resolution) {
        if ($resolution < 1) {
            throw new DomainException('Invalid image resolution. It should be greater than 0');
        }
        $this->resolution = $resolution;
    }

    /**
     * We are using the left top corner of a pixel as the complex number point.
     *
     * @param int $row
     * @param int $column
     * @return Complex
     */
    public function calculateComplexNumberForPixel(int $row, int $column): Complex {
        $this->validatePixelPosition($row, $column);

        $dResolution = DecimalFactory::from($this->resolution);
        $dRow = DecimalFactory::from($row);
        $dColumn = DecimalFactory::from($column);
        $_2 = DecimalFactory::from(2);

        // 2 is the Mandelbrot graph limit in real and imaginary parts
        $realPart = (($_2 / ($dResolution / $_2)) * $dColumn) - $_2;
        $imaginaryPart = $_2 - (($_2 / ($dResolution / $_2)) * $dRow);

        return new Complex($realPart, $imaginaryPart);
    }

    public function pixelBelongsToMandelbrotSet(int $row, int $column) {
        $c = $this->calculateComplexNumberForPixel($row, $column);
        return Set::contains($c);
    }

    /**
     * @return int
     */
    public function getResolution(): int {
        return $this->resolution;
    }

    /**
     * @param int $x
     * @param int $y
     */
    private function validatePixelPosition(int $x, int $y) {
        if ($x < 0) {
            throw new DomainException('Invalid negative x position');
        }

        if ($y < 0) {
            throw new DomainException('Invalid negative y position');
        }

        if ($x > $this->resolution - 1) {
            throw new DomainException('Invalid x position for current resolution');
        }

        if ($y > $this->resolution - 1) {
            throw new DomainException('Invalid y position for current resolution');
        }
    }
}