<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostumeSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'costume_id',
        'category',
        'size',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function costume()
    {
        return $this->belongsTo(Costume::class);
    }
}
