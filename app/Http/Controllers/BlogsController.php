<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogsResource;
use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BlogsResource::collection(
            Blog::where('user_id', Auth::user()->id)->get(),
        );
    }

    public function store(StoreBlogRequest $request)
    {
        $request->validated($request->all());

        $blog = Blog::create([
            'user_id' => Auth::user()->id,
            'topic'=>$request->topic,
            'body'=>$request->body,

        ]);

        return new BlogsResource($blog);
     
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
