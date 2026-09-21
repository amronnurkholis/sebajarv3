<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSize extends Model
{
    use HasFactory;

    protected $table = 'rental_sizes';

    protected $fillable = [
        'rental_id',
        'category',
        'size',
        'quantity',
    ];

    protected $casts = [
        'rental_id' => 'integer',
        'quantity' => 'integer',
    ];

    /**
     * Rental yang memiliki detail ukuran ini.
     */
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
}