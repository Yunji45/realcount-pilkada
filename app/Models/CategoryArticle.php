<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryArticle extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_article_id');
    }
}
