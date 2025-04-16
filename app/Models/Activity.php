<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'activity',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User')->withDefault([
            'name' => 'Admin',
        ]);
    }



}
