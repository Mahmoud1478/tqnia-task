<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\VerifyRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Api\Response\HasApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use  HasApiResponse;

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $code = (string)rand(100000, 999999);
        $data['verification_code'] = encrypt($code);
        $user = User::create($data);
        info("verification_code for $user->id => $code");
        $token = $user->createToken('app');
        return $this->successResponseWithToken(UserResource::make($user), explode('|', $token->plainTextToken)[1]);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('phone', $data['phone'])->first();
        if (!$user) {
            return $this->failedResponse(['phone' => 'Phone number doesn\'t exit'], 'login error');
        }
        if (!is_null($user->verification_code)){
            return $this->failedMessageResponse('unverified user');
        }
        if (!\Hash::check($data['password'], $user->password)) {
            return $this->failedResponse(['credential' => 'Wrong Credential'], 'login error');
        }
        $token = $user->createToken('app');
        return $this->successResponseWithToken(UserResource::make($user), explode('|', $token->plainTextToken)[1]);
    }
    public function verify(VerifyRequest $request)
    {
        /**
         * @var User $user
         */
        $user = User::where('phone',$request->phone)->first();
        if (is_null($user->verification_code)){
            return $this->successMessageResponse('Account Already Activated');
        }
        if ($user->decrypted_verification_code != $request->code) {
            return $this->failedMessageResponse('wrong code');
        }
        $user->verification_code = null;
        $user->save();
        return $this->successMessageResponse(__('Account Activated Successfully'));
    }
}
