<?php

namespace App\Models;

use App\Http\Helpers\General\Helper;
use App\Services\GeneralService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

/**
 * Class Post
 *
 * @property $id
 * @property $user_id
 * @property $template_id
 * @property $category_id
 * @property $title
 * @property $app_title
 * @property $slug
 * @property $excerpt
 * @property $description
 * @property $story_highlights
 * @property $canonical_url
 * @property $canonical_source
 * @property $type
 * @property $source_type
 * @property $push_notification
 * @property $social_sharing
 * @property $is_published
 * @property $status
 * @property $featured_image
 * @property $show_video_icon
 * @property $posted_at
 * @property $created_at
 * @property $updated_at
 * @property $MainCategory
 * @property $description_org
 * @property $is_rephrase
 * @property $is_title_rephrased
 * @property $org_title
 * @property $org_excerpt
 * @property $is_excerpt_rephrased
 * *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Author> $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostMeta> $meta
 * @property-read int|null $meta_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Post> $relatedPosts
 * @property-read int|null $related_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\Template|null $template
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAppTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCanonicalSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCanonicalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePushNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSocialSharing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSourceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStoryHighlights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @mixin \Eloquent
 */
class Post extends Model
{

    use HasFactory;
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'org_excerpt',
        'is_excerpt_rephrased',
        'org_title',
        'user_id',
        'template_id',
        'category_id',
        'title',
        'app_title',
        'slug',
        'excerpt',
        'description',
        'story_highlights',
        'canonical_url',
        'canonical_source',
        'type',
        'push_notification',
        'social_sharing',
        'is_published',
        'status',
        'source_type',
        'featured_image',
        'show_video_icon',
        'date',
        'author',
        'guid',
        'feed_id',
        'posted_at',
        'is_rephrase',
        'description_org',
        'is_title_rephrased'
    ];

    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }
    public function categories(){
        return $this->belongsToMany('App\Models\Category');
    }
    public function meta(){
        return $this->hasMany('App\Models\PostMeta');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id')->withDefault([
            'name'=>'Admin',
        ]);
    }
    public function template(){
        return $this->belongsTo('App\Models\Template');
    }
    public function feed(){
        return $this->belongsTo('App\Models\Feed')->withDefault([
            'name'=>'None'
        ]);
    }
    public function MainCategory(){
        return $this->belongsTo('App\Models\Category','category_id')->withDefault([
            'name'=>'none',
        ]);
    }
    public function relatedPosts(){
        return $this->belongsToMany('App\Models\Post','related_posts','post_id','related_post_id');
    }
    public function activity()
    {
        return $this->hasMany('App\Models\Activity','model_id',)->where('model_type','App\Models\Post');
    }

    /*public function getPostSlugAttribute(){
        return $this->slug.'-'.$this->id;
    }*/
//    public function getSlugAttribute($value){
//        $gService = new GeneralService();
//        return Helper::nameToUrl($value);
//    }

    public function postPositions(){
        return $this->hasMany('App\Models\ContentPositionDetail','model_id');
    }

    public function coments(){
        return $this->hasMany('App\Models\PostComment','post_id')->where('parent_id','0');
    }

    public function authors(){
        return $this->belongsToMany('App\Models\Author');
    }

    public function getPostSlugAttribute(){
        return $this->id.'-'.$this->slug;
    }


}
