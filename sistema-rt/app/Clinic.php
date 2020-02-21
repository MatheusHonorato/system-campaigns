<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $fillable = [
        'name', 'clinic_record', 'technical_manager', 'professional_record'
    ];
}
