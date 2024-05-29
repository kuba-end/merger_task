<?php

declare(strict_types=1);

namespace App\Services\Movie;

class BarTitlesStrategy implements TitlesStrategyInterface
{

    public function extractTitles(array $titles): array
    {
        $formattedTitles = [];
        if (isset($titles['titles'])) {
            foreach ($titles['titles'] as $movieData) {
                if (isset($movieData['title'])) {
                    $formattedTitles[] = $movieData['title'];
                }
            }
        }

        return $formattedTitles;
    }
}
