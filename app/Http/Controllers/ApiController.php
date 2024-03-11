<?php

namespace App\Http\Controllers;

use App\ApiUser;
use App\Models\Api;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = app(ApiUser::class)->user();

        $items = Api::query()
            ->where('user_id', '=', $user->id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'data' => $items
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            try {
                $token = generateToken('apis');
                $user = app(ApiUser::class)->user();

                Api::query()->create([
                    'user_id' => $user->id,
                    'token' => $token
                ]);

                return response()->json([
                    'message' => trans('api.success.created'),
                    'api_key' => $token
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

    public function destroy(Api $api): JsonResponse
    {
        return DB::transaction(function () use ($api) {
            try {
                $api->delete();

                return response()->json([
                    'message' => trans('api.success.deleted')
                ], Response::HTTP_OK);
            } catch (\Exception $e) {
                logger()->error($e);
                DB::rollBack();

                return response()->json([
                    'message' => trans('transaction.fail')
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
