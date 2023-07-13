<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\Users\UserResource;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index() {

        $user = auth()->user();

        // if(in_array("Administrator", $user->roles->pluck("name")->toArray())){
            return UserResource::collection(
                User::orderBy('created_at', 'desc')->get()
            );
        // } else {
        //     return UserResource::collection(
        //         User::orderBy('created_at', 'desc')
        //         ->where("id", $user->id)
        //         ->orWhere("creator_id", $user->id)
        //         ->get()
        //     );
        // }
    }

    public function store(Request $request) {
        $userExist = User::where('name', $request->name)
            ->where('email', $request->email)
            ->first();

        if($userExist) return response([
            'status' => 'error',
            'message' => 'User already exists, try a different one.'
        ]);

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'creator_id' => auth()->user()->id,
            'password' => bcrypt($fields['password']),
            'uuid' => Str::uuid()->toString()
        ]);

        $user->roles()->attach([2]);

        if(!$user) return response([
            'status' => 'error',
            'message' => 'User creation failed.'
        ]);

        $token = $user->createToken('token')->plainTextToken;
        $user = new UserResource($user);

        $response = [
            'status' => 'success',
            'message' => 'User created successfully.',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function update_user(Request $request)
    {
        $user = User::where("uuid", $request->uuid)->first();

        if($user && $request->password){
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return response()->json([
                "status" => "success",
                "message" => "User updated successfully.",
            ]);

        } else if($user && !$request->password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response()->json([
                "status" => "success",
                "message" => "User updated successfully.",
            ]);

        } else {
            return response()->json([
                "status" => "error",
                "message" => "User not found."
            ]);
        }
    }

    public function show($uuid) {
        return new UserResource(User::where('uuid', $uuid)->first());
    }
}
