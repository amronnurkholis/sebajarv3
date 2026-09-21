<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rental extends Model
{
    use HasFactory;

    protected $table = 'rentals';

    protected $fillable = [
        'user_id',
        'customer_name',
        'team_name',
        'phone',
        'costume_code',
        'quantity',
        'rental_start',
        'rental_end',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'rental_start' => 'date',
        'rental_end' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function costume(): BelongsTo
    {
        return $this->belongsTo(Costume::class, 'costume_code', 'code');
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(RentalSize::class);
    }
}
