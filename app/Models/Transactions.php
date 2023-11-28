<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function gudangs()
    {
        return $this->belongsTo(Gudangs::class, 'gudangs_id', 'id');
    }

    public function creteria()
    {
        return $this->belongsTo(Creteria::class, 'creterias_id', 'id');
    }
}
