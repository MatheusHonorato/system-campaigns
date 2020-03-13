<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCampaign extends Model
{
    protected $fillable = [
        'campaign_id', 'category_id'
    ];
}
