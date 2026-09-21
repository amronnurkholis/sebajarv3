<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostumeImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'costume_id',
        'image_path',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function costume()
    {
        return $this->belongsTo(Costume::class);
    }

    public function getImageUrlAttribute(): string
    {
        $path = ltrim((string) $this->image_path, '/');

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return asset('images/' . $path);
    }
}
