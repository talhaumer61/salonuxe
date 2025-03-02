<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services'; 

    protected $primaryKey = 'service_id'; 

    public $timestamps = false; 
    protected $fillable = [
        'service_status',
        'service_name',
        'service_href',
        'id_type',
        'service_price',
        'service_desc',
        'service_photo',
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
