<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\reportedDisease;


class Category extends Model
{
    // use HasFactory;
    public function reporteddisease(){
        return $this->hasMany(reportedDisease::class);
    }
}
