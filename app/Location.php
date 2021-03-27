<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    //Table in MySQL
    public $table = 'locations';

    //
    protected $fillable = [
        'name',
        'type',
        'dimension',
        'residents',
        'location',
        'url'

    ];

    protected $guarded = ['id'];

    //Not showed in queries
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'residents' => 'array'
    ];

    //Relation
    public function characters()
    {
        return $this->belongsToMany(Character::class);
    }
}
