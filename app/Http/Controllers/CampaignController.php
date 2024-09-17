<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $startDate = $request->input('start_date', now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $sortBy = $request->input('sort', 'name');
        $orderBy = $request->input('order', 'asc');
        $selectedBrand = $request->input('brand') ?? null;

        // Build the campaign query, filtering by brand if selected
        $query = Campaign::with(['brand'])->withMetrics($startDate, $endDate, $selectedBrand);

        if (!empty($selectedBrand)) {
            $query->where('campaigns.brand_id', $selectedBrand);
        }

        // Apply sorting based on the selected column
        switch ($sortBy) {
            case 'brand':
                $query->join('brands', 'campaigns.brand_id', '=', 'brands.id')
                    ->orderBy('brands.name', $orderBy);
                break;
            case 'impressions':
                $query->orderBy('total_impressions_count', $orderBy);
                break;
            case 'interactions':
                $query->orderBy('total_interactions_count', $orderBy);
                break;
            case 'conversions':
                $query->orderBy('total_conversions_count', $orderBy);
                break;
            case 'conversion_rate':
                // Handle sorting by conversion rate
                $query->orderBy(DB::raw('total_conversions_count / total_interactions_count'), $orderBy);
                break;
            default:
                $query->orderBy('campaigns.name', $orderBy);
                break;
        }
        
        $campaigns = $query->paginate(15);

        // Fetch brands
        $brands = Cache::remember('brands_list', 60 * 60, function () {
            return Brand::orderBy('name', 'asc')->get();
        });

        return view('campaigns.index', compact('brands', 'campaigns', 'startDate', 'endDate', 'sortBy', 'orderBy', 'selectedBrand'));
    }
}
