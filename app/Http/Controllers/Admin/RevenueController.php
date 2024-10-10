<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ImageUpload;
use App\Models\Doctor;
use App\Models\Revenue;
use Carbon\Carbon;

class RevenueController extends Controller
{

    public function revenueChart(Request $request)
    {
        $option = $request->input('filter', 'daily'); // Default filter to daily

        // Get revenue data based on the selected filter
        switch ($option) {
            case 'daily':
                $data = $this->getDailyRevenue();
                break;
            case 'weekly':
                $data = $this->getWeeklyRevenue();
                break;
            case 'monthly':
                $data = $this->getMonthlyRevenue();
                break;
            case 'yearly':
                $data = $this->getYearlyRevenue();
                break;
            default:
                $data = $this->getDailyRevenue();
        }

        return view('admin/revenue/revenueChart', compact('data', 'option'));
    }


    // Fetch daily revenue for the last 7 days
    private function getDailyRevenue()
    {

        return Revenue::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->get();
    }

    // Fetch weekly revenue for the last 7 weeks
    private function getWeeklyRevenue()
    {
        return Revenue::selectRaw('YEARWEEK(created_at) as week, SUM(amount) as total')
            ->groupBy('week')
            ->orderBy('week', 'ASC')
            ->whereBetween('created_at', [Carbon::now()->subWeeks(7), Carbon::now()])
            ->get();
    }

    // Fetch monthly revenue for the current year
    private function getMonthlyRevenue()
    {
        return Revenue::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->whereYear('created_at', Carbon::now()->year)
            ->get();
    }

    // Fetch yearly revenue for the last 5 years
    private function getYearlyRevenue()
    {
        return Revenue::selectRaw('YEAR(created_at) as year, SUM(amount) as total')
            ->groupBy('year')
            ->orderBy('year', 'ASC')
            ->whereBetween('created_at', [Carbon::now()->subYears(5), Carbon::now()])
            ->get();
    }
}
