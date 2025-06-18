<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes; // if you use soft deletes
use App\Models\Wishlist;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected static function booted()
    {
        static::deleting(function ($user) {
            // Remove all roles & permissions assigned to the user
            $user->roles()->detach();
            $user->permissions()->detach();
        });
    }
    public function wishlistItems()
    {   
        return $this->hasMany(Wishlist::class);
    }

    public function hasInWishlist($productId)
    {
        return $this->wishlistItems()->where('product_id', $productId)->exists();
    }
}
