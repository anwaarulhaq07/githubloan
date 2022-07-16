<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_history extends Model
{
    use HasFactory;
    protected $fillable = [ ];
    
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id ');
    }
}
