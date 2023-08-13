<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * This endpoint is used to get the current user && check if the token is valid.
     */
    public function me(Request $request)
    {
        return $request->user();
    }
}
