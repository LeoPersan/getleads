<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ['name'];

    public function calcMean()
    {
        $this->mean->calc();
        return true;
    }

    public function calcStandardDeviation()
    {
        $this->standardDeviation->calc();
        return true;
    }


    public function calcLeadsMatch()
    {
        foreach (Lead::all() as $lead) {
            $this->matches()->create([
                'lead_id' => $lead->id,
                'match' => $lead->calcMatch($this),
            ]);
        }
        return true;
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function standardDeviation()
    {
        return $this->hasOne(StandardDeviation::class);
    }

    public function mean()
    {
        return $this->hasOne(Mean::class);
    }

    public function matches()
    {
        return $this->hasMany(LeadsMatch::class);
    }
}
