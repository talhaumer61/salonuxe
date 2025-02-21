<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceType extends Model
{
    use HasFactory;

    protected $table = 'service_types'; // Specify table name if different from default
    protected $primaryKey = 'id'; // Primary key
    
    public $timestamps = false; // Disable timestamps if you are manually handling them (date_added, date_modify)

    protected $fillable = [
        'status', 
        'name', 
        'href', 
        'description', 
        'icon', 
        'id_added', 
        'id_modify', 
        'date_added', 
        'date_modify', 
        'is_deleted', 
        'id_deleted', 
        'date_deleted', 
        'ip_deleted'
    ];

}
