<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()
            ->where('role', 'customer')
            ->with('customer:id,user_id,address,contact')
            ->orderBy('name')
            ->get()
            ->map(fn (User $user): array => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'contact' => $user->customer?->contact,
                'address' => $user->customer?->address,
                'joinedAt' => $user->created_at?->toIso8601String(),
            ]);

        return response()->json(['data' => $users]);
    }
}
