<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return (new UserResource($request->user()))->setCustomWith([
            'message'       => 'اطلاعات کاربر'
        ]);
    }
}
