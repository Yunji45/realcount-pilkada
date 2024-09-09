<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_article_id',
        'title',
        'content',
        'image', // Kolom gambar yang baru ditambahkan
    ];

    public function categoryArticle()
    {
        return $this->belongsTo(CategoryArticle::class, 'category_article_id');
    }

}
