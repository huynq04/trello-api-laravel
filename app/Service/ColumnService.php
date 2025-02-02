<?php

namespace App\Service;

use App\Models\Column;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function moveColumnInBoard($request_body): void
    {
        $orderedColumnIds = $request_body['ordered_column_ids']; // Mảng ID đã sắp xếp

        if (empty($orderedColumnIds)) {
            throw new Exception('Invalid ordered_column_ids', 400);
        }

        $caseStatement = "CASE id ";
        foreach ($orderedColumnIds as $index => $id) {
            $caseStatement .= "WHEN {$id} THEN " . ($index + 1) . " ";
        }
        $caseStatement .= "END";

        DB::table('columns')
            ->whereIn('id', $orderedColumnIds)
            ->update(['order_index' => DB::raw($caseStatement)]);
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
