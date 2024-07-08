<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogsResource;
use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogsController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BlogsResource::collection(
            Blog::where('user_id', Auth::user()->id)->get()
        );
    }

    public function store(StoreBlogRequest $request)
    {
        $request->validated($request->all());

        $blog = Blog::create([
            'user_id' => Auth::user()->id,
            'topic' => $request->topic,
            'body' => $request->body,
            'pinPost' => filter_var($request->pinPost, FILTER_VALIDATE_BOOLEAN),
        ]);

        return new BlogsResource($blog);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Use a single private method to handle both existence and authorization checks
        $blog = $this->findBlogOrFailAndAuthorize($id);
        if ($blog instanceof \Illuminate\Http\JsonResponse) {
            return $blog;
        }

        return $this->success(new BlogsResource($blog));
    }

    public function update(Request $request, $id)
    {
        // Use a single private method to handle both existence and authorization checks
        $blog = $this->findBlogOrFailAndAuthorize($id);
        if ($blog instanceof \Illuminate\Http\JsonResponse) {
            return $blog;
        }

        $blog->update($request->all());

        return $this->success(new BlogsResource($blog), 'Blog updated successfully');
    }

    public function destroy($id)
    {
        // Use a single private method to handle both existence and authorization checks
        $blog = $this->findBlogOrFailAndAuthorize($id);
        if ($blog instanceof \Illuminate\Http\JsonResponse) {
            return $blog;
        }

        $blog->delete();

        return $this->success(null, 'Blog successfully deleted', 200);
    }

    // Private method to check if the blog exists and if the user is authorized
    private function findBlogOrFailAndAuthorize($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return $this->error(null, 'Blog does not exist', 404);
        }

        if (Auth::user()->id !== $blog->user_id) {
            return $this->error(null, 'You are not authorized to make this request', 403);
        }

        return $blog;
    }
}
