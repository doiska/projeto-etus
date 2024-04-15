<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SubscriptionController extends Controller
{
    public function store(StoreSubscriptionRequest $request): JsonResponse
    {
        $subscription = new Subscriber($request->validated());
        $subscription->save();

        return response()->json([
            "status" => "success",
            "message" => "New email successfully registered."
        ], ResponseAlias::HTTP_CREATED);
    }
}
