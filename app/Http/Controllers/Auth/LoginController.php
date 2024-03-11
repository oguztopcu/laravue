<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['logout']);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::query()->where('email', '=', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }
        
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token
        ], Response::HTTP_OK);
    }

    public function register(RegisterRequest $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $user = User::query()->create($request->validated());

                return response()->json([
                    'message' => trans('user.success.create'),
                    'data' => $user
                ], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                logger()->error($e);
                DB::rollBack();

                return response()->json([
                    'message' => trans('transaction.fail')
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }

    public function getUser(): JsonResponse
    {
        return response()->json([
            'user' => auth('sanctum')->user()
        ], Response::HTTP_OK);
    }

    public function logout(): JsonResponse
    {
        $user = auth('sanctum')->user();

        $user->tokens()->delete();

        return response()->json([
            'message' => trans('auth.logout')
        ], Response::HTTP_OK);
    }
}
