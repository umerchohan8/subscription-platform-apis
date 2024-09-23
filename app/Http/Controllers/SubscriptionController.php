<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\User;
use App\Models\Website;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function subscribe(StoreSubscriptionRequest $request)
    {
        $data = $request->safe()->only(['website_id', 'email', 'name']);

        $website = Website::where('uuid', $data['website_id'])
            ->first();

        if (!$website) {
            return response()->json([
                'success' => false,
                'message' => 'Website not found',
            ], 401);
        }

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['uuid' => Str::uuid(), 'name' => $data['name']]
        );

        $subscription = $user->subscriptions()->updateOrCreate(
            ['user_id' => $user->id, 'website_id' => $website->id],
            ['uuid' => Str::uuid()],
        );

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully.',
            'data' => $subscription,
        ], 201);
    }
}
