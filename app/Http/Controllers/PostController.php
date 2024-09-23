<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Stores a new post.
     *
     * @param StorePostRequest $request
     * @return JsonResponse
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $data = $request->safe()->only(['website_id', 'title', 'description']);

        $website = Website::where('uuid', $data['website_id'])->first();

        if (!$website) {
            return response()->json([
                'success' => false,
                'message' => 'Website not found',
            ], 401);
        }

        $data['uuid'] = Str::uuid();
        $post = $website->posts()->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully.',
            'data' => $post,
        ], 201);
    }
}
