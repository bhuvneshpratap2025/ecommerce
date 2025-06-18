<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     title="Product",
 *     required={"name", "price", "description", "stock", "category_id"},
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="price", type="number", format="float"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="stock", type="integer", format="int64"),
 *     @OA\Property(property="category_id", type="integer", format="int64")
 * )
 */
class Product extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'stock',
        'price','category_id'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
