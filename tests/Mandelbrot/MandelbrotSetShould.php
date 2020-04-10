<?php

namespace Tests\Mandelbrot;

use ArbitraryPrecisionComplex\Complex;
use ArbitraryPrecisionComplex\DecimalFactory;
use Mandelbrot\Formula;
use Mandelbrot\Set;

class MandelbrotSetShould extends BaseTestClass {

    /** @test */
    public function contain_minus_one() {

        $delta = '0.00000000000000000000000001';

        $minusOne = self::c('-1', '0');
        $z0 = new Complex(DecimalFactory::zero(), DecimalFactory::zero());
        $z = new Complex(DecimalFactory::zero(), DecimalFactory::zero());

        // Iter 1
        $f = Formula::calculate($z0, $minusOne);    // f(z) = 0² - 1 = -1
        $this->assertEquals(self::c('-1', '0')->__toString(), $f->__toString());

        // Iter 2
        $f = Formula::calculate($f, $minusOne);    // f(z) = -1² - 1 = 0
        $this->assertTrue($f->compareTo(self::c('0', '0'), DecimalFactory::from($delta)));

        // Iter 3
        $f = Formula::calculate($f, $minusOne);    // f(z) = -0² - 1 = -1
        $this->assertTrue($f->compareTo(self::c('-1', '0'), DecimalFactory::from($delta)));

        // TODO
        // Pending to fix this issue:
        // https://github.com/josecelano/php-complex/issues/1
//        // Iter 4
//        $f = Formula::calculate($f, $minusOne);    // f(z) = -1² - 1 = 0
//
//        $this->assertTrue(
//            $f->compareTo(self::c('0', '0'), DecimalFactory::from($delta)),
//            sprintf("Result %s is not equal to expected result %s", $f->__toString(), self::c('0', '0')->__toString())
//        );
    }

    /** @test */
    public function not_include_complex_number_with_real_or_imaginary_part_greater_then_2() {
        $this->assertTrue(Set::bailout(self::c('2.1', '0')));
        $this->assertTrue(Set::bailout(self::c('-2.1', '0')));
        $this->assertTrue(Set::bailout(self::c('0', '2.1')));
        $this->assertTrue(Set::bailout(self::c('0', '-2.1')));
    }

    /**
     * @test
     * @dataProvider some_complex_number_that_belong_to_mandelbrot_set
     * @param Complex $c
     */
    public function contain_complex_numbers_that_do_not_diverge_when_iterated_from_z0_for_mandelbrot_sequence(Complex $c) {
        $this->assertTrue(
            Set::contains($c),
            sprintf("Number %s do not belong to Mandelbrot Set", $c->__toString())
        );
    }

    /**
     * @test
     * @dataProvider some_complex_number_that_do_not_belong_to_mandelbrot_set
     * @param Complex $c
     */
    public function not_contain_complex_numbers_that_diverge_when_iterated_from_z0_for_mandelbrot_sequence(Complex $c) {
        $this->assertFalse(Set::contains($c));
    }

    public function some_complex_number_that_belong_to_mandelbrot_set() {
        return [
            [self::c('0', '0')],
            // TODO: it's failing
            // Pending to fix this issue:
            // https://github.com/josecelano/php-complex/issues/1
            //[self::c('-1', '0')],
            [self::c('-0.5', '0')],
            [self::c('-0.5', '0.5')],
            [self::c('-0.5', '0.5')],
        ];
    }

    public function some_complex_number_that_do_not_belong_to_mandelbrot_set() {
        return [
            [self::c('-2', '2')],
            [self::c('0', '2')],
            [self::c('2', '2')],
            [self::c('0', '2')],
            [self::c('0', '-2')],
            [self::c('-2', '-2')],
            [self::c('-2', '0')],
        ];
    }
}