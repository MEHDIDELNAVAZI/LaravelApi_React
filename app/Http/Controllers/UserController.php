<?php

namespace App\Http\Controllers;

use App\Http\Requests\Registerrequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getuserdata(string $id) {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // Return the user data
        return response()->json($user);
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $user = User::find($id);
    
    // Validation rules for fields other than email and password
    $commonRules = [
        'name' => 'required',
        // ... other validation rules ...
    ];
    
    // Check if the email is being updated
    if ($user->email !== $request->input('email')) {
        // Perform uniqueness validation for the new email
        $emailRules = [
            'email' => 'required|email|unique:users',
        ];
    } else {
        $emailRules = [];
    }
    
    // Password validation rules if a new password is provided
    if ($request->input('password') != '')  {
        $passwordRules = [
            'password' => 'required|confirmed|min:8',
        ];
    } else {
        $passwordRules = [];
    }
    
    // Combine all validation rules
    $validationRules = array_merge($commonRules, $emailRules, $passwordRules);
    
    // Validate the request
    $request->validate($validationRules);
    
    // Update the user's information
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    
    // Update password only if provided
    if ($request->input('password') != '') {
        $user->password = Hash::make($request->input('password'));
    }
    
    // ... other update logic ...
    
    $user->save();
    
    return response()->json(['message' => 'User updated successfully']);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);

    }
}
