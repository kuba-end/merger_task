<?php

declare(strict_types=1);

namespace App\Services\Movie;

class BazTitlesStrategy implements TitlesStrategyInterface
{

    public function extractTitles(array $titles): array
    {
        $formattedTitles = [];
        if (isset($titles['titles'])) {
            foreach ($titles['titles'] as $movieData) {
                if (is_string($movieData)) {
                    $formattedTitles[] = $movieData;
                }
            }
        }

        return $formattedTitles;
    }
}
