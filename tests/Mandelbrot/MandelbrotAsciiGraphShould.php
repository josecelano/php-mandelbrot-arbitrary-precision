<?php

namespace Tests\Mandelbrot;

use Mandelbrot\AsciiGraph;

class MandelbrotAsciiGraphShould extends BaseTestClass {
    /** @test */
    public function generate_a_mandelbrot_ascii_graph_string_for_a_1x1_string() {
        $asciiGraph = new AsciiGraph(1);

        $output = $asciiGraph->generate();

        $this->assertEquals(' ', $output);
    }

    /** @test */
    public function generate_a_mandelbrot_ascii_graph_string_for_a_2x2_string() {
        $asciiGraph = new AsciiGraph(2);

        $output = $asciiGraph->generate();

        $expectedOutput = implode([
            "  \n",
            " *"
        ]);

        $this->assertEquals($expectedOutput, $output);
    }

    /** @test */
    public function generate_a_mandelbrot_ascii_graph_string_for_a_3x3_string() {
        // Pending to fix this issue:
        // https://github.com/josecelano/php-complex/issues/1
        $this->markTestSkipped();

        $asciiGraph = new AsciiGraph(3);

        $output = $asciiGraph->generate();

        $expectedOutput = implode([
            "   \n",
            "   \n",
            "   ",
        ]);

        $this->assertEquals($expectedOutput, $output);
    }

    /** @test */
    public function generate_a_mandelbrot_ascii_graph_string_for_a_4x4_string() {

        // Pending to fix this issue:
        // https://github.com/josecelano/php-complex/issues/1
        $this->markTestSkipped();

        $asciiGraph = new AsciiGraph(4);

        $output = $asciiGraph->generate();

        $expectedOutput = implode([
            "    \n",
            "    \n",
            " ** \n",
            "    ",
        ]);

        $this->assertEquals($expectedOutput, $output);
    }

    /** @test */
    public function generate_a_mandelbrot_ascii_graph_string_for_a_8x8_string() {

        // Pending to fix this issue:
        // https://github.com/josecelano/php-complex/issues/1
        $this->markTestSkipped();

        $asciiGraph = new AsciiGraph(8);

        $output = $asciiGraph->generate();

        $expectedOutput = implode([
            "        \n",
            "        \n",
            "        \n",
            "   **   \n",
            "  ***   \n",
            "   **   \n",
            "        \n",
            "        ",
        ]);

        $this->assertEquals($expectedOutput, $output);
    }

    /** @test */
    public function generate_a_mandelbrot_ascii_graph_string_for_a_160x160_string() {
        // Pending to fix this issue:
        // https://github.com/josecelano/php-complex/issues/1
        $this->markTestSkipped();

        $asciiGraph = new AsciiGraph(160);

        $output = $asciiGraph->generate();

        $expectedOutput = file_get_contents(__DIR__ . "/../fixtures/mandelbrot-160x160.txt");
        $this->assertEquals($expectedOutput, $output);
    }
}