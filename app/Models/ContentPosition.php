<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ContentPosition
 *
 * @property $id
 * @property $key
 * @property $slots
 * @property $posts
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ContentPosition extends Model
{

    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['key','slots','posts','status','content_type'];


    public function details(){
        return $this->hasMany('App\Models\ContentPositionDetail')->orderBy('sequence','asc');
    }

}
