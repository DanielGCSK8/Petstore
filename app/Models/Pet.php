<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';

    protected $fillable = [
        'category',
        'name',
        'photoUrls',
        'tags',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function tags()
    {
        return $this->belongsTo(Tag::class, 'tags');
    }

}
