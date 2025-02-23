<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salon extends Model
{
    use HasFactory;

    protected $table = 'salons'; // Specify table name if different from default
    protected $primaryKey = 'salon_id'; // Primary key
    
    public $timestamps = false; // Disable timestamps if you are manually handling them (date_added, date_modify)

    protected $fillable = [
        'salon_status',
        'id_user',
        'salon_name',
        'salon_href',
        'salon_address',
        'id_city',
        'salon_logo',
        'opening_time',
        'closing_time',
        'salon_phone',
        'salon_email',
        'salon_about',
        'id_added',
        'id_modify',
        'date_added',
        'date_modify',
        'is_deleted',
        'id_deleted',
        'date_deleted',
        'ip_deleted',
    ];
}
