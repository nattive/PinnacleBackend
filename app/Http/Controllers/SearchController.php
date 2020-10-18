<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Resources\BlogPostResource;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function search($searchterm)
    {

        $searchResults = (new Search())
            ->registerModel(\App\Course::class, 'title')
            ->registerModel(\App\MainCategory::class, 'name')
            ->perform($searchterm);

        return $searchResults;
    }

    public function searchBlog($searchTerm)
    {

        $blogPosts = BlogPost::query()->where('title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('tags', 'LIKE', "%{$searchTerm}%")->get();
        return BlogPostResource::collection($blogPosts);
    }

}
