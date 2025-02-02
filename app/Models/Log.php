<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'sl_logfile';
    public $timestamps = false;  // Disable automatic timestamps

    // Define the fillable fields
    protected $fillable = [
        'id_user',
        'urlpath',
        'action',
        'id_record',
        'dated',
        'ip',
        'remarks',
    ];
}
