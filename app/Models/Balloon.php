<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balloon extends Model
{
    use HasFactory;
    protected $fillable = [ ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ballon_payments()
    {
        return $this->hasMany(Balloon_payment::class, 'ballon_id', 'id');
    }
}
