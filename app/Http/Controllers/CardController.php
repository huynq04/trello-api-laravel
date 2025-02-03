<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCardRequest;
use App\Http\Requests\UpdateCardOrderIndex;
use App\Http\Requests\UpdateCardOrderIndexInDifferentColumn;
use App\Services\CardService;
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

    /**
     * @throws \Exception
     */
    public function moveCardInColumn(UpdateCardOrderIndex $request): JsonResponse
    {
        $this->cardService->moveCardInColumn($request->validated()['ordered_card_ids']);
        return response()->json(['message' => 'Card order updated successfully'], 200);
    }

    /**
     * @throws \Exception
     */
    public function moveCardToDifferentColumn(UpdateCardOrderIndexInDifferentColumn $request): JsonResponse
    {
        $this->cardService->moveCardToDifferentColumn(
            $request->validated()['card_id'],
            $request->validated()['next_column_id'],
            $request->validated()['next_card_order_index'],
            $request->validated()['prev_card_order_index']
        );

        return response()->json(['message' => 'Card moved successfully'], 200);
    }
}
