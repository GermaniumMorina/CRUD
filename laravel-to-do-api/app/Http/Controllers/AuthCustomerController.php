<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
/**
 * Summary of AuthCustomerController
 */
class AuthCustomerController extends Controller
{
     use HasApiTokens;
    public function register(Request $request) {
        $fields = $request->validate([
            'name'=> 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt ($fields['password'])
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }
     public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6'
        ]);
       //check email
       $user = User::where('email', $fields['email'])->first();
       //check password
       if(!$user || !Hash::check($fields['password'], $user->password)){
        return response([
            'message' => 'You are not registered'
        ], 401);
       }
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
            'csrf_token' => csrf_token()
        ];
        return response()->json([$response])->header('X-CSRF-Token', csrf_token());
    }
    /**
     * Summary of logout
     * @param Request $request
     * @return array<string>
     */
    public function logout(Request $request) {
        Auth::user()->tokens->each(function($token, $key) {
    $token->delete();
});
        return [
            'message' => 'Logged out'
        ];
    }
}