<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = User::mobile($request->safe()->mobile)
                ->first();

            if (
                blank($user) ||
                !Hash::check($request->safe()->password, $user->password)
            ) {
                return Json::response(401, 'کاربری با اطلاعات ارسالی یافت نشد');
            }

            $user->accessToken = $user->createToken('user')->accessToken;

            DB::commit();

            return (new UserResource($user))->setCustomWith([
                'message'       => 'ورود موفقیت آمیز'
            ]);

            //
        } catch (Exception $e) {
            
            DB::rollBack();
            info($e);

            return Json::response(500, 'There is a problem with your request');
        }
    }
}
