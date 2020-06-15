<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LeadsMatch extends Model
{
    protected $fillable = ['portfolio_id', 'lead_id', 'match'];

    public function getMatchAttribute()
    {
        return $this->attributes['match'] * 100;
    }

    public function scopeUf(Builder $builder, $uf = false)
    {
        if (is_null($uf)) return $builder;
        return $builder->where('sg_uf', $uf);
    }

    public function scopeMinMatch(Builder $builder, $match = false)
    {
        if (is_null($match)) return $builder;
        return $builder->where('match', '>=', $match / 100);
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('joinLeads', function (Builder $builder) {
            $builder->join('leads', 'leads.id', '=', 'leads_matches.lead_id');
        });
    }
}
