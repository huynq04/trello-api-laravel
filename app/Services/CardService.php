<?php

namespace App\Services;

use App\Models\Card;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CardService
{
    public function modelQuery(): Builder
    {
        return Card::query();
    }

    public function create($request_body): Model|Builder
    {
        $maxOrder = $this->modelQuery()->where('column_id', $request_body['column_id'])
            ->max('order_index');

        $card = $this->modelQuery()->create([
            'title' => $request_body['title'],
            'column_id' => $request_body['column_id'],
            'order_index' => $maxOrder !== null ? $maxOrder + 1 : 1
        ]);

        return $card;
    }

    /**
     * @throws Exception
     */
    public function moveCardInColumn($orderedCardIds): void
    {
        if (empty($orderedCardIds)) {
            throw new Exception('Invalid ordered_cards_ids', 400);
        }

        $caseStatement = "CASE id ";
        foreach ($orderedCardIds as $index => $id) {
            $caseStatement .= "WHEN {$id} THEN " . ($index + 1) . " ";
        }
        $caseStatement .= "END";

        DB::table('cards')
            ->whereIn('id', $orderedCardIds)
            ->update(['order_index' => DB::raw($caseStatement)]);
    }

    /**
     * @throws Exception
     */
    public function moveCardToDifferentColumn(
        $card_id,
        $next_column_id,
        $next_card_order_index,
        $prev_card_order_index
    ): void
    {
        // update card column_id
        $this->modelQuery()->find($card_id)->update([
            'column_id' => $next_column_id
        ]);

        // update card order_index in the current column
        if ($prev_card_order_index != []) {
            $this->moveCardInColumn($prev_card_order_index);
        }

        // update card order_index in the next column
        $this->moveCardInColumn($next_card_order_index);
    }
}
