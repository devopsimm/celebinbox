<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Class Author
 *
 * @property $id
 * @property $name
 * @property $slug
 * @property $type
 * @property $twitter
 * @property $facebook
 * @property $profile_picture
 * @property $email
 * @property $phone
 * @property $details
 * @property $is_publish
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static \Illuminate\Database\Eloquent\Builder|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereIsPublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Author whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Author extends Model
{

    use HasSlug;
    static $rules = [
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
        'twitter',
        'facebook',
        'profile_picture',
        'email',
        'phone',
        'details',
        'designation',
        'is_publish',
        'status'
    ];
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : \Spatie\Sluggable\SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function posts(){
        return $this->belongsToMany('App\Models\Post');
    }


}
