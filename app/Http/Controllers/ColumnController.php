<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateColumnRequest;
use App\Http\Requests\UpdateColumnOrderIndex;
use App\Http\Requests\UpdateColumnRequest;
use App\Service\ColumnService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    private ColumnService $columnService;
    public function __construct(ColumnService $columnService)
    {
        $this->columnService = $columnService;
    }

    public function store(CreateColumnRequest $request): JsonResponse
    {
        $column = $this->columnService->createNew($request->validated());
        return response()->json($column, 200);
    }

    public function update(UpdateColumnRequest $request, int $id): JsonResponse
    {
        $column = $this->columnService->update($request->validated(), $id);
        return response()->json($column, 200);
    }

    /**
     * @throws Exception
     */
    public function moveColumnInBoard(UpdateColumnOrderIndex $request): JsonResponse
    {
        $this->columnService->moveColumnInBoard($request->validated());
        return response()->json(['message' => 'Column order updated successfully'], 200);
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): JsonResponse
    {
        $this->columnService->delete($id);
        return response()->json(['message' => 'Column deleted successfully'], 200);
    }

}
