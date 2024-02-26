<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\Api\Response\HasApiResponse;

class PostController extends Controller
{
    use HasApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse(
            PostCollection::make(auth()->user()->posts()->with('tags')->paginate())
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['cover_image'] = $request->file('cover_image')->store('post_cover_images');
        $tags = $data['tags'];
        unset($data['tags']);
        $post = Post::create($data);
        $post->tags()->attach($tags);
        $post->load('tags');
        return $this->successResponse(PostResource::make($post));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        abort_unless($post->user_id == auth()->id(), 404);
        $post->load('tags');
        return $this->successResponse(PostResource::make($post));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $data = $request->validated();
        if ($request->hasFile('cover_image')){
            $post->deleteCoverImage();
            $data['cover_image'] = $request->file('cover_image')->store('post_cover_images');
        }else{
            unset($data['cover_image']);
        }
        $tags = $data['tags'];
        unset($data['tags']);
        $post->update($data);
        $post->tags()->sync($tags);
        $post->load('tags');
        return $this->successResponse(PostResource::make($post));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_unless($post->user_id == auth()->id(), 404);
        $post->delete();
        return $this->successMessageResponse('Data deleted Successfully');

    }
}
