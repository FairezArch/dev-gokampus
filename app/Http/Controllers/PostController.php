<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Events\ClearCache;
use Illuminate\Http\Response;
use App\Services\PostService\Action;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    protected $postService;

    public function __construct(Action $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->success($this->postService->indexData());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        //
        $save = $this->postService->storeData($request);

        $arr_caches = ['post-cache'];
        event(new ClearCache($arr_caches));

        return $save ? $this->success() : $this->fail(__('validation.something_went_wrong'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return $this->success($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdatePostRequest  $request
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
        $update = $this->postService->updateData($request, $post);

        $arr_caches = ['post-cache'];
        event(new ClearCache($arr_caches));

        return $update ? $this->success() : $this->fail(__('validation.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $delete = $this->postService->deleteData($post);

        $arr_caches = ['post-cache'];
        event(new ClearCache($arr_caches));
        
        return $delete ? $this->success([], [], Response::HTTP_NO_CONTENT) : $this->fail(__('validation.something_went_wrong'));
    }
}
