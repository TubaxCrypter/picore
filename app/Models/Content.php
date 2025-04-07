<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Kitlesel olarak atanabilir özellikler
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'status',
        'meta_title',
        'meta_description',
        'published_at'
    ];

    /**
     * Tarih olarak işlenecek özellikler
     */
    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Kategori ilişkisi
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Yazar ilişkisi
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Duruma göre içerikleri filtreleme
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Yayınlanmış içerikleri filtreleme
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }
} 