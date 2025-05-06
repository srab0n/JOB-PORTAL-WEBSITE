<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Admin extends Model
{
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'user_id',
        'role',
    ];

    // Admin "inherits" User by linking to it
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
