<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Spare;

class Procurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'spare_id', 'quantity', 'supplier', 'status', 'description'
    ];

    public function spare()
    {
        return $this->belongsTo(Spare::class);
    }
}

