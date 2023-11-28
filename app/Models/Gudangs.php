<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gudangs extends Model
{
    use HasFactory;
    protected $guarded = [];

    public  function statuses()
    {
        return $this->belongsTo(Statuses::class, 'status_id', 'id');
    }
}
