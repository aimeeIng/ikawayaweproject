<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;
    protected $table = 'diseases';
    protected $fillable = ['disease_name','category','image','description'];
    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    // public function comments(){
    //     return $this->hasMany(Comment::class);
    // }
}
