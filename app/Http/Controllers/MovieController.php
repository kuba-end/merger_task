<?php

namespace App\Http\Controllers;

use App\Services\Movie\MovieFacade;
use App\Services\Movie\MovieFacadeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private MovieFacadeInterface $movieFacade;

    public function __construct(MovieFacadeInterface $movieFacade)
    {
        $this->movieFacade = $movieFacade;
    }

    public function getTitles(Request $request): JsonResponse
    {
        $titles = $this->movieFacade->getTitles();

        if ($titles === [MovieFacade::SICK_MESSAGE]) {
            return response()->json([
                'status' => 'failure'
            ]);
        }

        return response()->json(
            $titles
        );
    }
}
