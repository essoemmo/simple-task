<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\PageRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    use ResponseTrait;

    public function index(PageRequest $pageRequest): JsonResponse
    {
        $comments = Comment::paginate($pageRequest->page_count);
        return self::successResponsePaginate(data: CommentResource::collection($comments)->response()->getData(true));
    }

    public function store(CommentRequest $request): JsonResponse
    {
        $comment = Comment::create($request->validated());
        return self::successResponse('created', CommentResource::make($comment));
    }

    public function update(CommentRequest $request, Comment $comment): JsonResponse
    {
        $comment->update($request->validated());
        return self::successResponse('updated', CommentResource::make($comment));
    }

    public function show(Comment $comment): JsonResponse
    {
        return self::successResponse('show', CommentResource::make($comment));
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();
        return self::successResponse('deleted');
    }
}
