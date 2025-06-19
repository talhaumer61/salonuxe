<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs'; // Specify table name if different from default
    protected $primaryKey = 'id'; // Primary key
    
    public $timestamps = false; // Disable timestamps if you are manually handling them (date_added, date_modify)

    protected $fillable = [
        'status', 
        'question', 
        'answer', 
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
