<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCardRequest;
use App\Service\CardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardController extends Controller
{
    private CardService $cardService;
    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    public function store(CreateCardRequest $request): JsonResponse
    {
        $card = $this->cardService->create($request->validated());
        return response()->json($card, 200);
    }
}
