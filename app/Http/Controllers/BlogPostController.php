<?php

namespace App\Http\Controllers;

use App\Admin;
use App\BlogCategory;
use App\BlogPost;
use App\Http\Requests\BlogPostRequest;
use App\Http\Resources\BlogPostResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BlogPostResource::collection(BlogPost::all());
    }

    public function createSlug($title)
    {
        $slug = Str::slug($title);
        $allSlugs = $this->getRelatedSlugs($slug);
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        return response('can not create unique name', 500);
    }

    protected function getRelatedSlugs($slug)
    {
        return BlogPost::select('slug')->where('slug', 'like', $slug . '%')->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostRequest $request)
    {
        $admin = Admin::findOrFail($request->admin_id);
        $slug = $this->createSlug($request->title);
        $Url = Cloudinary::upload($request->imageUrl)->getSecurePath();
        $data = array_merge($request->validated(), ['slug' => $slug, 'admin_id' => $admin -> id, 'imageUrl' => $Url]);
        BlogPost::create($data);
        return response()->json('Blog post uploaded Successfully', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->first();
        return new BlogPostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * GET ALL BLOG POST
     *  @return \Illuminate\Http\Response
     *
     */

     public function category()
     {
         return BlogCategory::with("blogPosts")->get();
     }
}
