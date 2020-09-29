<?php

namespace App\Http\Controllers;

use App\User;
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
}
