<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertCampaign extends Model
{
    protected $fillable = [
        'clinic_id', 'campaign_id', 'description'
    ];
}
