<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadsMatch extends Model
{
    protected $fillable = ['portfolio_id', 'lead_id', 'match'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
