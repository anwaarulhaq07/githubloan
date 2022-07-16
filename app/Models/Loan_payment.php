<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_payment extends Model
{
    use HasFactory;
    protected $fillable = [ ];
    
    public function loan()
    {
        return $this->belongsTo(MortaAuto_loange::class, 'loan_id ');
    }
}
