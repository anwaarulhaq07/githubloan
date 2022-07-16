<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balloon_payment extends Model
{
    use HasFactory;

    public function balloon()
    {
        return $this->belongsTo(Balloon::class, 'ballon_id');
    }
}
