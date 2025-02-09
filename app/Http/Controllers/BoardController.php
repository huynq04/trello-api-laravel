<?php

namespace App\Http\Controllers;

use App\Enums\UserBoardRole;
use App\Http\Requests\CreateBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use App\Models\User;
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


    public function getBoards(Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 12);

        $boards = Board::query()
            ->whereHas('userBoard', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json($boards, 200);
    }

    public function store(CreateBoardRequest $request): JsonResponse
    {
        $board = $this->boardService->createNew($request->validated());

        $boardRole = $this->boardService->createUserBoardRole(
            $request->user()->id,
            $board->id,
            UserBoardRole::Owner->value
        );

        return response()->json($board, 201);
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
