<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file',
        'tanggal',
        'approval_status',
        'verification_status',
        'file_invoice',
        'tanggal_transfer',
        'nominal_transfer',
    ];
}
