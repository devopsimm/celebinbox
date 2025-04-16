<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentPositionDetail extends Model
{

    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_position_id',
        'model_id',
        'sequence',
        'type',
        'status',
    ];

    public function post(){
        return $this->belongsTo('App\Models\Post','model_id');
    }
    public function product(){
        return $this->belongsTo('App\Models\Product','model_id');
    }



}
