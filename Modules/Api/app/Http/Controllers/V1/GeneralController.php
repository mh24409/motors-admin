<?php

namespace Modules\Api\Http\Controllers\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Http\Controllers\BaseApiController;

class GeneralController extends BaseApiController
{
    public function layoutData(Request $request): JsonResponse
    {
        return $this->createdResponse([
            'language' => app()->getLocale(),
        ], 'Layout data retrieved.');
    }
}