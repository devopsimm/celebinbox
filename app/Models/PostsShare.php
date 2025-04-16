<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostsShare
 *
 * @property $id
 * @property $post_id
 * @property $title
 * @property $description
 * @property $image
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PostsShare extends Model
{

    protected $table = 'posts_share';
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
//    protected $fillable = ['post_id','title','description','image','status'];

        protected  $guarded = [];
    public function post(){
        return $this->belongsTo('App\Models\Post','post_id');
    }

}
