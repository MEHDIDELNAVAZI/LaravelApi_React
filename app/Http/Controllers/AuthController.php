<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loginrequest;
use App\Http\Requests\Registerrequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken as AccessToken;


class AuthController extends Controller
{
    // Register a new user
    public function register(Registerrequest $request)
    {
        // Validation passed, handle the registration logic here
        $data = $request->validated();
        /** @var User $user  */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // Make sure to hash the password before storing it in the database
        ]);
        $user->last_login_at = now(); // Set the current timestamp
        $user->save(); // Save the user model to persist the last_login_at change

        $token = $user->createToken('main');
        return response(compact('user', 'token'));
    }

    // Login
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        /** @var User $user */
        $user = Auth::user();
        $user->last_login_at = now(); // Set the current timestamp
        $user->save(); // Save the user model to persist the last_login_at change

        $token = $user->createToken('authToken')->plainTextToken;
        
        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
}

     public function logout(Request $request)
    {
         /** @var User $user  */
         // Get the authenticated user using the 'user()' method on the request
        $user = $request->user();
        // Revoke the current access token for the authenticated user
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        // Perform any additional logout logic if neede
        // Return a successful response with status code 204 (No Content)
        return response()->json(null, 204);
    }

    public function  getusers() {
        $users = User::all();
        return response()->json($users);
    }

}
