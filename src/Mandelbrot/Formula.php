<?php

namespace Mandelbrot;

use ArbitraryPrecisionComplex\Complex;

class Formula {
    public static function calculate(Complex $z, Complex $c) {
        return $z->multiply($z)->add($c);
    }
}