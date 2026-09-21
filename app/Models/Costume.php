<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costume extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'image',
        'description',
        'status',
    ];

    public function sizes()
    {
        return $this->hasMany(CostumeSize::class);
    }

    public function images()
    {
        return $this->hasMany(CostumeImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function activeSizes()
    {
        return $this->hasMany(CostumeSize::class)
            ->where('quantity', '>', 0);
    }

    /**
     * Total item baju yang tersedia pada inventory kostum.
     *
     * Catatan:
     * Untuk sistem rental berbasis set, perhitungan final
     * ketersediaan akan dilakukan oleh service/controller
     * berdasarkan kombinasi baju + celana dan periode rental.
     */
    public function getTotalSetsAttribute(): int
    {
        return (int) $this->sizes()
            ->where('category', 'baju')
            ->sum('quantity');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        $path = ltrim((string) $this->image, '/');

        // URL eksternal tetap didukung.
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Format lama: images/...
        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        // Format baru: path relatif terhadap public/images.
        return asset('images/' . $path);
    }


}
