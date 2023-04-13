<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'price',
        'category_id',
        'image'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
