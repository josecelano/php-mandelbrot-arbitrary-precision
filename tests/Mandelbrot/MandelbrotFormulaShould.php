<?php

namespace Tests\Mandelbrot;

use ArbitraryPrecisionComplex\Complex;
use ArbitraryPrecisionComplex\DecimalFactory;
use Mandelbrot\Formula;

class MandelbrotFormulaShould extends BaseTestClass {
    /**
     * @test
     * @dataProvider  someComplexNumberToTestMandelbrotFormula
     * @param Complex $z
     * @param Complex $c
     * @param Complex $expectedResult
     */
    public function calculate_the_mandelbrot_function(Complex $z, Complex $c, Complex $expectedResult) {
        $result = Formula::calculate($z, $c);

        //$this->assertEquals($expectedResult->__toString(), $result->__toString());

        $delta = '0.00000000000000000000000001';
        $this->assertTrue(
            $result->compareTo($expectedResult, DecimalFactory::from($delta)),
            sprintf("Result %s is not equals to expected result %s", $result->__toString(), $expectedResult->__toString())
        );
    }

    public function someComplexNumberToTestMandelbrotFormula() {

        $_0 = self::c('0', '0');
        $_1 = self::c('1', '0');
        $_2 = self::c('2', '0');
        $_i = self::c('0', '1');
        $_05 = self::c('0.5', '0');
        $_05i = self::c('0', '0.5');

        $_1_i = self::c('1', '1');
        $_1_05i = self::c('1', '0.5');

        return [

            // [z, c, z² + c]

            // With z=0 -> return c
            [$_0, $_0, $_0],        // 0² + 0 = 0
            [$_0, $_1, $_1],        // 0² + 1 = 1
            [$_0, $_i, $_i],        // 0² + i = i
            [$_0, $_05i, $_05i],    // 0² + 0.5i = 0.5i

            // With z=1 -> return 1 + c
            [$_1, $_0, $_1],        // 1² + 0 = 1
            [$_1, $_1, $_2],        // 1² + 1 = 2
            [$_1, $_i, $_1_i],      // 1² + i = 1 + i
            [$_1, $_05i, $_1_05i],  // 1² + 0.5i = 1 + 0.5i

            // With z=-1 -> return 1 + c
            [self::c('-1', '0'), $_0, $_1],        // -1² + 0 = 1
            [self::c('-1', '0'), $_1, $_2],        // -1² + 1 = 2
            [self::c('-1', '0'), $_i, $_1_i],      // -1² + i = 1 + i
            [self::c('-1', '0'), $_05i, $_1_05i],  // -1² + 0.5i = 1 + 0.5i

            // With z=-1 c=-1
            [self::c('-1', '0'), self::c('-1', '0'), $_1], // -1² - 1 = 0

            // With z=i -> return i + c
            [$_i, $_0, self::c('-1', '0')],     // i² + 0 = -1
            [$_i, $_1, $_0],                        // i² + 1 = -1 + 1 = 0
            [$_i, $_i, self::c('-1', '1')],     // i² + i = -1 + i
            [$_i, $_05i, self::c('-1', '0.5')], // i² + 0.5i = -1 + 0.5i

            // With z=0.5 -> return 0.5 + c
            [$_05, $_0, self::c('0.25', '0')],      // 0.5² + 0 = 0.25
            [$_05, $_1, self::c('1.25', '0')],      // 0.5² + 1 = 1.25
            [$_05, $_i, self::c('0.25', '1')],      // 0.5² + i = 0.25 + i
            [$_05, $_05i, self::c('0.25', '0.5')],  // 0.5² + 0.5i = 1 + 0.5i
        ];
    }
}