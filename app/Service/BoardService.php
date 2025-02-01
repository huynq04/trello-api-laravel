<?php

namespace App\Service;

use App\Models\Board;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BoardService
{
    public function modelQuery(): Builder
    {
        return Board::query();
    }

    public function createNew($request_body): Model|Builder
    {
        $newBoard = [
            ...$request_body,
            'slug' => Str::slug($request_body['title']),
        ];

        return $this->modelQuery()->create($newBoard);
    }

    /**
     * @throws Exception
     */
    public function getDetail($id): Builder|array|Collection|Model
    {
        $board = Board::with([
            'columns' => function ($query) {
                $query->orderBy('order_index'); // sort columns with order_index
            },
            'columns.cards' => function ($query) {
                $query->orderBy('order_index'); // sort cards with order_index
            }
        ])->find($id);

        if (!$board) {
            throw new Exception('Board not found', 404);
        }

        return $board;
    }

    /**
     * @throws Exception
     */
    public function update($id, $request_body): Model|Collection|Builder|array
    {
        $board = $this->modelQuery()->find($id);

        if (!$board) {
            throw new Exception('Board not found', 404);
        }

        $board->update($request_body);

        return $board;
    }
}
