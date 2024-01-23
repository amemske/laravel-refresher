<?php

namespace App\Models;

use App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public function profile(){
        return $this->hasOne(Profile::class);
    }
}
