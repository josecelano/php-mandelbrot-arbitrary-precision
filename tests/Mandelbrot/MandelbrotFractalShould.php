<?php

namespace Tests\Mandelbrot;

use ArbitraryPrecisionComplex\Complex;
use Mandelbrot\Fractal;

class MandelbrotFractalShould extends BaseTestClass {
    /** @test */
    public function have_a_resolution() {
        $fractal = new Fractal(100);
        $this->assertEquals(100, $fractal->getResolution());
    }

    /** @test */
    public function have_a_resolution_greater_than_0() {
        $this->expectException('DomainException');
        new Fractal(-1);
    }

    /** @test */
    public function calculate_the_complex_number_which_represents_a_pixel_in_the_graph_for_resolution_1() {
        $fractal = new Fractal(1);

        // Complex number is the top left corner of the pixel
        $c = $fractal->calculateComplexNumberForPixel(0, 0);

        $this->assertEquals(self::c('-2', '2'), $c);
    }

    /** @test */
    public function calculate_the_complex_number_which_represents_a_pixel_in_the_graph_for_resolution_2() {
        $fractal = new Fractal(2);

        $px00 = $fractal->calculateComplexNumberForPixel(0, 0);
        $px01 = $fractal->calculateComplexNumberForPixel(0, 1);
        $px10 = $fractal->calculateComplexNumberForPixel(1, 0);
        $px11 = $fractal->calculateComplexNumberForPixel(1, 1);

        $pixels = [
            [$px00, $px01],
            [$px10, $px11],
        ];

        $expectedPixels = [
            [self::c('-2','2'), self::c('0', '2')],
            [self::c('-2', '0'), self::c('0', '0')],
        ];

        $this->assertEquals($expectedPixels, $pixels);
    }

    /** @test */
    public function calculate_the_complex_number_which_represents_a_pixel_in_the_graph_for_resolution_4() {
        $resolution = 4;

        $fractal = new Fractal($resolution);

        $complexForPixel = [];
        for ($row = 0; $row < $resolution; $row++) {
            for ($column = 0; $column < $resolution; $column++) {
                $complexForPixel[$row][$column] = $fractal->calculateComplexNumberForPixel($row, $column);
            }
        }

        $expectedComplexForPixel = [
            [self::c('-2', '2'), self::c('-1', '2'), self::c('0', '2'), self::c('1','2')],
            [self::c('-2','1'), self::c('-1', '1'), self::c('0', '1'), self::c('1', '1')],
            [self::c('-2', '0'), self::c('-1', '0'), self::c('0','0'), self::c('1','0')],
            [self::c('-2','1'), self::c('-1','1'), self::c('0','1'), self::c('1','1')],
        ];

        $this->assertEquals($expectedComplexForPixel, $complexForPixel);
    }
}