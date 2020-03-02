<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignPost extends Model
{
    protected $fillable = [
        'campaign_id', 'post_id'
    ];
}
