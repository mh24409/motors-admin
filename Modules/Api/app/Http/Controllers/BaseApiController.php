<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Api\Traits\ApiResponse;

abstract class BaseApiController extends Controller
{
    use ApiResponse;
}
