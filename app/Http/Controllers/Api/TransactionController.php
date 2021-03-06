<?php

namespace App\Http\Controllers\Api;

use Exception;
use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\Contracts\TransactionServiceContract;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionServiceContract $transactionServiceContract)
    {
        $this->transactionService = $transactionServiceContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request): JsonResponse
    {
        try {
            if($transaction = $this->transactionService->add($request->all())) {
                return response()->json(
                    $transaction,
                    JsonResponse::HTTP_CREATED
                );
            }
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
