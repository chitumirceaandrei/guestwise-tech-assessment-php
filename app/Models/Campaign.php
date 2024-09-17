<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_id',
    ];

    public function scopeWithMetrics($query, $startDate, $endDate, $brandId)
    {
        $filtered = $query
            ->join('impressions_statistics', function($join) use ($startDate, $endDate, $brandId) {
                $join->on('campaigns.id', '=', 'impressions_statistics.campaign_id')
                    ->whereBetween('impressions_statistics.occurred_at', [$startDate, $endDate]);
                if ($brandId) {
                    $join->where('impressions_statistics.brand_id', $brandId);
                }
            })
            ->join('interactions_statistics', function($join) use ($startDate, $endDate, $brandId) {
                $join->on('campaigns.id', '=', 'interactions_statistics.campaign_id')
                    ->whereBetween('interactions_statistics.occurred_at', [$startDate, $endDate]);
                if ($brandId) {
                    $join->where('interactions_statistics.brand_id', $brandId);
                }
            })
            ->join('conversions_statistics', function($join) use ($startDate, $endDate, $brandId) {
                $join->on('campaigns.id', '=', 'conversions_statistics.campaign_id')
                    ->whereBetween('conversions_statistics.occurred_at', [$startDate, $endDate]);
                if ($brandId) {
                    $join->where('conversions_statistics.brand_id', $brandId);
                }
            })
            ->select(
                'campaigns.*',
                DB::raw('SUM(impressions_statistics.impressions_count) as total_impressions_count'),
                DB::raw('SUM(interactions_statistics.interactions_count) as total_interactions_count'),
                DB::raw('SUM(conversions_statistics.conversions_count) as total_conversions_count')
            );

        if($brandId) {
            $filtered->groupByRaw('campaigns.brand_id, campaigns.id');
        } else {
            $filtered->groupBy('campaigns.id');
        }

        return $filtered;
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function impressions()
    {
        return $this->hasMany(Impression::class);
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }

    public function conversions()
    {
        return $this->hasMany(Conversion::class);
    }
}
