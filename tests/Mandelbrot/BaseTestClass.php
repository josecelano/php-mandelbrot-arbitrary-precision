<?php

namespace Tests\Mandelbrot;

use ArbitraryPrecisionComplex\Complex;
use ArbitraryPrecisionComplex\DecimalFactory;
use PHPUnit\Framework\TestCase;

class BaseTestClass extends TestCase {
    protected $object;

    protected function expect($object) {
        $this->object = $object;
        return $this;
    }

    protected function toBe($object) {
        $this->assertEquals($this->object, $object);
    }

    protected static function c($r, $i) {
        return new Complex(DecimalFactory::from($r), DecimalFactory::from($i));
    }
}