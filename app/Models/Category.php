<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
/**
 * Class Category
 *
 * @property $id
 * @property $name
 * @property $slug
 * @property $type
 * @property $description
 * @property $parent_id
 * @property $image
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property $seo_details
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property-read Category|null $parentCategories
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{

//    use HasSlug;

    static $rules = [
        'photo' => 'image',
        'type' => 'required',
        'name' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'parent_id',
        'image',
        'seo_details',
        'status',
        'is_featured',
    ];
    /**
     * Get the options for generating the slug.
     */
//    public function getSlugOptions() : \Spatie\Sluggable\SlugOptions
//    {
//        return SlugOptions::create()
//            ->generateSlugsFrom('name')
//            ->saveSlugsTo('slug');
//    }

    public function parentCategories(){
        return $this->belongsTo('App\Models\Category','parent_id','id');
    }
    public function childCategories(){
        return $this->hasMany('App\Models\Category','parent_id','id')->orderBy('sort_by','ASC');
    }

    public function posts(){
        return $this->hasMany('App\Models\Post','category_id');
    }
    public function publishedPosts(){
        return $this->hasMany('App\Models\Post','category_id')->where('is_published','1');
    }
    public function publishedPostsToNow(){
        return $this->hasMany('App\Models\Post','category_id')->where('is_published','1')->where('posted_at','<=', Carbon::now()->toDateTimeString());
    }

    public function subCatPosts(){
        return $this->belongsToMany('App\Models\Post')->where('is_published','1');
    }

}
