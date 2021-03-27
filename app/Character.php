<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    //Table in MySQL
    public $table = 'characters';

    //
    protected $fillable = [
        'name',
        'status',
        'species',
        'type',
        'gender',
        'origin',
        'location',
        'image',
        'episode'
    ];

    protected $guarded = ['id'];

    //Not showed in queries
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'origin' => 'array',
        'location' => 'array',
        'episodes' => 'array',
    ];

    //Relation
    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }
}
