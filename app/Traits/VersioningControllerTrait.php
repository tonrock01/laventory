<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

trait VersioningControllerTrait
{
    /**
     * @param  Model  $model
     * @param  int    $requestVersion
     * @return JsonResponse|null
     */
    public function checkVersion(Model $model, int $requestVersion): ?JsonResponse
    {
        if (!isset($model->version)) {
            return response()->json([
                'success' => false,
                'message' => 'This model does not support versioning.'
            ], 500);
        }

        if ($requestVersion !== $model->version) {
            return response()->json([
                'success' => false,
                'message' => 'The data has been modified by another user.',
                'current_version' => $model->version,
            ], 409);
        }

        return null;
    }
}
