<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use phpseclib3\Crypt\Hash;

class AuthService
{
    public function register($request): array
    {
        $result = ['error' => null];
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $user = User::query()->create($data);
            $tokenResult = $user->createToken('Client Access Token');
            $result['result'] = $this->tokenPrepare($tokenResult);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result['error'] = $e->getMessage();
        }
        return $result;
    }

    public function login($request): array
    {
        $result = ['error' => null];
        $username = $request->username;
        $password = $request->password;
        $user = User::query()
            ->where('username', $username)
            ->firstOrFail();
        if (!Hash::check($password, $user->password)) {
            abort(401);
        }
        $tokenResult = $user->createToken('Client Access Token');
        $result['result'] = $this->tokenPrepare($tokenResult);
        return $result;
    }

    private function tokenPrepare($tokenResult): array
    {
        return [
            'access_token' => $tokenResult->accessToken,
            'refresh_token' => $tokenResult->token->refresh_token,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ];
    }
}
