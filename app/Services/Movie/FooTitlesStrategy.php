<?php

declare(strict_types=1);

namespace App\Services\Movie;

class FooTitlesStrategy implements TitlesStrategyInterface
{
    public function extractTitles(array $titles): array
    {
        if (!isset($titles['titles'])) {
            return array_values($titles);
        }

        return [];
    }
}

