<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ResponseTrait;

    public function index(PageRequest $pageRequest): JsonResponse
    {
        $posts = Post::paginate($pageRequest->page_count);
        return self::successResponsePaginate(data: PostResource::collection($posts)->response()->getData(true));
    }

    public function store(PostRequest $request): JsonResponse
    {
        $post = Post::create($request->validated());
        return self::successResponse('created', PostResource::make($post));
    }

    public function update(PostRequest $request, Post $post): JsonResponse
    {
        $post->update($request->validated());
        return self::successResponse('updated', PostResource::make($post));
    }

    public function show(Post $post): JsonResponse
    {
        return self::successResponse('show', PostResource::make($post));
    }

    public function destroy(Post $post): JsonResponse
    {
        $post->delete();
        return self::successResponse('deleted');
    }
}
