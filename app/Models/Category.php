<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Kitlesel olarak atanabilir özellikler
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order'
    ];

    /**
     * İçerik ilişkisi
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    /**
     * Ebeveyn kategori ilişkisi
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Alt kategoriler ilişkisi
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
} 