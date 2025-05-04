<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="User Management API",
 *     description="API for managing users in the Fullstack Evaluation Project"
 * )
 */

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json($user, 201);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}