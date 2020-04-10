<?php

namespace Mandelbrot;

use DomainException;

class AsciiGraph {
    const MANDELBROT_POINT_CHAR = '*';
    const BACKGROUND_CHAR = ' ';

    private int $resolutionInCharacters;

    public function __construct(int $resolutionInCharacters) {
        if ($resolutionInCharacters < 1) {
            throw new DomainException('Invalid resolution. Minimum number of characters must be 1');
        }
        $this->resolutionInCharacters = $resolutionInCharacters;
    }

    public function generate() {
        $numberOfLines = $this->resolutionInCharacters;
        $output = '';

        for ($line = 0; $line < $numberOfLines; $line++) {
            $output .= $this->generateLine($line) . "\n";
        }

        return $this->removeLastLineBreak($output);
    }

    /**
     * @param int $lineNumber
     * @return string
     */
    private function generateLine(int $lineNumber): string {
        $fractal = new Fractal($this->resolutionInCharacters);

        $numberOfColumns = $this->resolutionInCharacters;
        $output = '';

        for ($column = 0; $column < $numberOfColumns; $column++) {
            $char = self::BACKGROUND_CHAR;

            if ($fractal->pixelBelongsToMandelbrotSet($lineNumber, $column)) {
                $char = self::MANDELBROT_POINT_CHAR;
            }

            $output .= $char;
        }

        return $output;
    }

    /**
     * @param string $output
     * @return string
     */
    private function removeLastLineBreak(string $output): string {
        return rtrim($output, "\n");
    }
}