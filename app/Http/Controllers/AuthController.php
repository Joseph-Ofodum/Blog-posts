<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;


   public function login(LoginUserRequest $request){

        $request->validated($request->all());
        

       if (!Auth::attempt($request->only('email', 'password'))) {
        return $this->error('', 'Credentials do not match', 401);
    }

    $user = User::where('email', $request->email)->first();

    return $this->success([
        'user' => $user,
        'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
    ]);

    }

    public function register(StoreUserRequest $request){

        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
            'phone_number'=> $request->phone_number,
        ]);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken,
        ]);
     }


     public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();

        Auth::guard("web")->logout();

        return $this->success([
            'message' => 'You have been logged out.'
        ]);
     }
}




