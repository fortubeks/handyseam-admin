<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outfit extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'parent_id',
        'price',
        'user_id',
        'measurement_details'
    ];
    public function subOutfits(){
        return $this->hasMany('App\Models\Outfit');
    }
    public function parentOutfit(){
        return $this->hasOne('App\Models\Outfit');
    }
    public function outfitImages(){
        return $this->hasMany('App\Models\OutfitImage');
    }
    
}
