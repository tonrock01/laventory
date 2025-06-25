<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $data = User::paginate(10);

        return response()->json([
            'success' => true,
            'data' => $data,
        ], 201);
    }

    /**
     * Change password
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        //
        $user = Auth::user();
        $this->userService->update($user, $request->only('password'));
        return response()->json([
            'success' => true,
            'message' => ('Successful')
        ], 200);
    }
}
