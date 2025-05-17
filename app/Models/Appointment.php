<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'id_client',
        'id_salon',
        'id_service',
        'client_name',
        'client_phone',
        'client_email',
        'appointment_date',
        'appointment_time',
        'service_price',
        'status',
        'href',
        'id_added',
        'id_modify',
        'date_added',
        'date_modify',
        'is_deleted',
        'id_deleted',
        'date_deleted',
        'ip_deleted'
    ];

    public $timestamps = false;
}
