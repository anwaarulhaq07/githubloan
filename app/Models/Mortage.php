<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mortage extends Model
{
    use SoftDeletes;
    use HasFactory;


    public $table = 'mortages'; 


    protected $fillable = [
        
        'name',
        'loandamoutn',
        'downpayment',
        'percentage',
        'loan_terms',
        'start_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'mortage_id', 'id');
    }
   
  
}
