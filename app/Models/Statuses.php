<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statuses extends Model
{
    use HasFactory;
    protected $guarded = [];

    function gudangs()
    {
        return $this->hasMany(Gudangs::class, 'status_id', 'id');
    }
}
