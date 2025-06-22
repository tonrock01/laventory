<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\AssignRoleRequest;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\json;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $data = $this->roleService->index($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    public function assignRole(AssignRoleRequest $request, User $userId)
    {
        $data = $this->roleService->assignRole($request->all(), $userId);

        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Assign role success'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Assign role failed'
            ], 200);
        }
    }
}
