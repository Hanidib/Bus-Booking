<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        // Only return the authenticated user's data
        return response()->json(auth()->user());
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function show($id)
    {
        // Authorization: Users can only view their own data
        $user = User::findOrFail($id);
        
        if (auth()->user()->userId !== $user->userId) {
            return response()->json(['error' => 'Unauthorized. You can only view your own profile.'], 403);
        }
        
        return $user;
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Authorization: Users can only update their own data
        if (auth()->user()->userId !== $user->userId) {
            return response()->json(['error' => 'Unauthorized. You can only update your own profile.'], 403);
        }
        
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Authorization: Users can only delete their own account
        if (auth()->user()->userId !== $user->userId) {
            return response()->json(['error' => 'Unauthorized. You can only delete your own account.'], 403);
        }
        
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
