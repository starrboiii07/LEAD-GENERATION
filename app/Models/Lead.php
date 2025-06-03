<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
    'name', 'email', 'phone', 'contact_type', 'assigned_to', 'status', 'created_date', 'last_activity'
];
}
