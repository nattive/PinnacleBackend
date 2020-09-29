<?php

namespace App;

use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Model;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
class MainCategory extends Model   implements Searchable
{
    protected $fillable = [
        'name',
    ];
  public function getSearchResult(): SearchResult
     {

         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $this-> SubCategories,
            ['type' => 'main_category']
         );
     }

    public function SubCategories()
    {
        return $this -> hasMany(SubCategory::class);
    }
}
