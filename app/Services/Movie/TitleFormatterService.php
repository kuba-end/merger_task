<?php

declare(strict_types=1);

namespace App\Services\Movie;

class TitleFormatterService
{
    private array $titlesStrategy;

    public function __construct(TitlesStrategyInterface ...$titlesStrategy)
    {
        $this->titlesStrategy = $titlesStrategy;
    }

    public function format(array $titles): array
    {
        $allTitles = [];
        foreach ($this->titlesStrategy as $strategy) {
            $formattedTitles = $strategy->extractTitles($titles);
            $allTitles = array_merge($allTitles, $formattedTitles);
        }

        return $allTitles;
    }
}
