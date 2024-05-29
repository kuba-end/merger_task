<?php

namespace App\Services\Movie;

interface TitlesStrategyInterface
{
    public function extractTitles(array $titles): array;
}
