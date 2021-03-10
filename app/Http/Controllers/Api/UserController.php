<?php

namespace App\Http\Controllers\Api;

use Exception;
use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Contracts\UserServiceContract;

class UserController extends Controller
{
    /**
     * @var UserServiceContract
     */
    private $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserServiceContract $userServiceContract
     */
    public function __construct(UserServiceContract $userServiceContract)
    {
        $this->userService = $userServiceContract;
    }

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json($this->userService->all());
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
