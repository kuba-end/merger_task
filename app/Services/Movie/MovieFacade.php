<?php

declare(strict_types=1);

namespace App\Services\Movie;

use External\Foo\Exceptions\ServiceUnavailableException as FooException;
use External\Bar\Exceptions\ServiceUnavailableException as BarException;
use External\Baz\Exceptions\ServiceUnavailableException as BazException;
use External\Foo\Movies\MovieService as FooMovieService;
use External\Bar\Movies\MovieService as BarMovieService;
use External\Baz\Movies\MovieService as BazMovieService;

class MovieFacade implements MovieFacadeInterface
{
    public const SICK_MESSAGE = 'Server did not respond six times in a row, which is almost imposible!';
    private FooMovieService $fooMovieService;
    private BarMovieService $barMovieService;
    private BazMovieService $bazMovieService;
    private TitleFormatterService $titleFormatterService;

    private int $maxAllows = 5;

    public function __construct(
        FooMovieService $fooMovieService,
        BarMovieService $barMovieService,
        BazMovieService $bazMovieService,
        TitleFormatterService $titleFormatterService
    ) {
        $this->fooMovieService = $fooMovieService;
        $this->barMovieService = $barMovieService;
        $this->bazMovieService = $bazMovieService;
        $this->titleFormatterService = $titleFormatterService;
    }

    public function getTitles(): array
    {
        $cacheKey = 'movie_titles_cache_key';
        if (cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $movieServices = [
            $this->fooMovieService,
            $this->barMovieService,
            $this->bazMovieService,
        ];

        $allTitles = [];
        foreach ($movieServices as $movieService) {
            try {
                $titles = $movieService->getTitles();
                $formattedTitles = $this->titleFormatterService->format($titles);
                $allTitles = array_merge($allTitles, $formattedTitles);
            } catch (FooException|BarException|BazException $exception) {
                $titles = $this->retry($movieService);
                if ([] === $titles) {
                    return [self::SICK_MESSAGE];
                }
                $allTitles = array_merge($allTitles, $titles);

            }
        }

        cache()->put($cacheKey, $allTitles, 10800);

        return $allTitles;
    }

    private function retry(mixed $movieService): array
    {
        $counter = 0;
        $titles = [];
        while ($counter < $this->maxAllows) {
            try {
                $counter++;
                return $movieService->getTitles();
            } catch (FooException|BarException|BazException $exception){
                continue;
            }
        }

        return $titles;
    }
}
