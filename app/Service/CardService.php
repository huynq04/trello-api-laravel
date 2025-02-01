<?php

namespace App\Service;

use App\Models\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
}
