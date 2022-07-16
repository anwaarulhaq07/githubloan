<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [ ];
    
    public function mortage()
    {
        return $this->belongsTo(Mortage::class, 'mortage_id ');
    }
    
}
