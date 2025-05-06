<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'designation',
        'mobile',
        'user_type',
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
        'password' => 'hashed',
    ];

    /**
     * Get the admin record associated with the user.
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Create admin record when user is created
        static::created(function ($user) {
            if ($user->user_type === 'admin') {
                Admin::create([
                    'user_id' => $user->id,
                    'role' => 'admin'
                ]);
            }
        });
    }
}
