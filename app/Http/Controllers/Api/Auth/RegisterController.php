<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();

        try {

            $userId = User::create([
                'first_name'    => $request->safe()->first_name,
                'last_name'     => $request->safe()->last_name,
                'mobile'        => $request->safe()->mobile,
                'password'      => Hash::make($request->safe()->password)
            ])
                ->id;

            $user = User::findOrFail($userId);

            $user->accessToken = $user->createToken('user')->accessToken;

            DB::commit();

            return new UserResource($user);

            //
        } catch (Exception $e) {

            DB::rollBack();

            return Json::response(500, 'There is a problem with your request');
        }
    }
}
