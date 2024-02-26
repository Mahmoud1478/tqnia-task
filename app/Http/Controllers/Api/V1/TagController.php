<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TagRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\Api\Response\HasApiResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use HasApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse(TagCollection::make(Tag::paginate()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        return $this->successResponse(TagResource::make(Tag::create($request->validated())));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        return $this->successResponse(TagResource::make($tag));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return $this->successMessageResponse('Data deleted Successfully');
    }
}
