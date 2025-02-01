<?php

namespace App\Service;

use App\Models\Column;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ColumnService
{
    public function modelQuery(): Builder
    {
        return Column::query();
    }

    public function createNew($request_body): Model|Builder
    {
        $maxOrder = $this->modelQuery()->where('board_id', $request_body['board_id'])
            ->max('order_index');

        $column = $this->modelQuery()->create([
            'title' => $request_body['title'],
            'board_id' => $request_body['board_id'],
            'order_index' => $maxOrder !== null ? $maxOrder + 1 : 1
        ]);

        return $column;
    }

    public function update($request_body,int $id): Model|Builder
    {
        $column = $this->modelQuery()->find($id);

        $column->update($request_body);

        return $column;
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): void
    {
        // check if column exists and delete it
        $column = $this->modelQuery()->find($id);
        if (!$column) {
            throw new Exception('Column not found', 404);
        }
        $column->delete();
    }
}
