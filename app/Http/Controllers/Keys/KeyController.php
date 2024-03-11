<?php

namespace App\Http\Controllers\Keys;

use App\ApiUser;
use App\Models\Key;
use App\Http\Requests\Keys\KeyStoreRequest;
use App\Http\Requests\Keys\KeyUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class KeyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = app(ApiUser::class)->user();

        $items = Key::query()
            ->where('user_id', '=', $user->id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'data' => $items
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        $user = app(ApiUser::class)->user();

        $key = Key::query()
            ->where('user_id', '=', $user->id)
            ->where('key', '=', $request->input('name'))
            ->first();

        if (! $key) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        return response()->json([
            'data' => $key
        ], Response::HTTP_OK);
    }

    public function store(KeyStoreRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            try {
                $user = app(ApiUser::class)->user();

                $key = Key::query()
                    ->where('user_id', '=', $user->id)
                    ->where('key', '=', $request->input('key'))
                    ->first();

                if (! $key) {
                    $key = Key::query()->create([
                        'user_id' => $user->id,
                        'key' => $request->input('key'),
                        'value' => $request->input('value')
                    ]);
                } else {
                    $key->update([
                        'key' => $request->input('key'),
                        'value' => $request->input('value')
                    ]);
                }

                return response()->json([
                    'message' => trans('key.success.created'),
                    'data' => $key
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

    public function show(Key $key): JsonResponse
    {
        return response()->json([
            'data' => $key
        ]);
    }

    public function destroy(Key $key): JsonResponse
    {
        return DB::transaction(function () use ($key) {
            try {
                $key->delete();

                return response()->json([
                    'message' => trans('key.success.deleted')
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
