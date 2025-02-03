<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Services\BoardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    private BoardService $boardService;
    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
    }

    public function store(CreateBoardRequest $request): JsonResponse
    {
        $board = $this->boardService->createNew($request->validated());
        return response()->json($board, 200);
    }

    /**
     * @throws \Exception
     */
    public function show(int $id): JsonResponse
    {
        $board = $this->boardService->getDetail($id);
        return response()->json($board, 200);
    }

    /**
     * @throws \Exception
     */
    public function update(int $id, UpdateBoardRequest $request): JsonResponse
    {
        $board = $this->boardService->update($id, $request->all());
        return response()->json($board, 200);
    }
}
