<?php

namespace App\Http\Controllers;

use App\Admin;
use App\FreeResources;
use App\Http\Requests\FreeResourceRequest;
use App\Http\Resources\ContentLibraryResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;

class FreeResourcesController extends Controller
{
    public function index()
    {
        return ContentLibraryResource::collection(FreeResources::all());
    }
    //ifueko omoigui okauru
    public function store(FreeResourceRequest $request)
    {
        // $admin = Admin::findOrFail);
        $Url = Cloudinary::upload($request->banner)->getSecurePath();
        $data = [
            'slug' => $this->createSlug(request('title')),
            'banner' => $Url,
        ];
        $freeResources = FreeResources::create(array_merge($data, $request->only([
            'title',
            'admin_id',
            'subtitle',
            'free_resource_category_id',
            'body',
        ])));
        if (request('file')) {
        $file = Cloudinary::upload($request->file)->getSecurePath();
            $freeResources->mediaFiles()->create([
                'name' => request('filename'),
                'type' => request('mediaType'),
                'caption' => request('mediaCaption'),
                'link' => $file,
            ]);
        }
        return response()->json('Free resource uploaded', 200);
    }
    public function createSlug($title)
    {
        $slug = Str::slug($title);
        $allSlugs = $this->getRelatedSlugs($slug);
        // If we haven't used it before then we are all good.
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
    public function show($slug)
    {
        $resource = FreeResources::where("slug", $slug)->first();
        return new ContentLibraryResource($resource);
    }
    protected function getRelatedSlugs($slug)
    {
        return FreeResources::select('slug')->where('slug', 'like', $slug . '%')->get();
    }
}
