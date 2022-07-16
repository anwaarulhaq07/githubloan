<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balloon_installment extends Model
{
    use HasFactory;

    public $fillable = ['balloon_id','install_id','status','late_fee','payment','principal','interest','balance'];
}
