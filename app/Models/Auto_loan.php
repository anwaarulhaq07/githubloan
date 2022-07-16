<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto_loan extends Model
{
    use HasFactory;
    // public $timestamps = false;
    protected $fillable = [
        'id',
        'amount',
        'downpayment',
        'percentage',
        'loan_terms',
        'starttime',
        'user_id '
     ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payments()
    {
        return $this->hasMany(Loan_payment::class, 'loan_id', 'id');
    }
}
