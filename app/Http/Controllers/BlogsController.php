<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogsResource;
use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class BlogsController extends Controller
{

    use HttpResponses;
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
            'pinPost' => filter_var($request->pinPost, FILTER_VALIDATE_BOOLEAN),

        ]);
        
        return new BlogsResource($blog);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Blog $blog)
    // {
    //     if(Auth::user()->id !== $blog -> user_id){
    //         return $this->error('', 'You are not authorized to make this request', 403);
    //     }
    //     return new BlogsResource($blog);
    //     //
    // }


    public function show($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return $this->error(null, 'Blog does not exist', 404);
        }

        if (Auth::user()->id !== $blog->user_id) {
            return $this->error(null, 'You are not authorized to make this request', 403);
        }

        return $this->success(new BlogsResource($blog));
    }

    public function update(Request $request, Blog $blog)
    {
        if (Auth::user()->id !== $blog->user_id) {
            return $this->error(null, 'You are not authorized to make this request', 403);
        }

        $blog->update($request->all());

        return new BlogsResource($blog);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response(null, 204);
    }
}
