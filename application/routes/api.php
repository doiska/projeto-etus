<?php

use App\Http\Controllers\api\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::post("/subscribe", [SubscriptionController::class, "store"]);

