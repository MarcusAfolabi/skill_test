<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    use HasFactory;
    protected $table = ['s_m_s'];
    
    protected $fillable = ['sender_id', 'recipients', 'message'];
}
