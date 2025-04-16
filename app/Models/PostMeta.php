<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostMetum
 *
 * @property $id
 * @property $post_id
 * @property $key
 * @property $value
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereValue($value)
 * @mixin \Eloquent
 */
class PostMeta extends Model
{

    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['key','value','status','post_id'];



}
