<?php

namespace App\Http\Controllers;

use App\Models\GameLogs;
use App\Models\PlayStation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MainDashboardController extends Controller
{
    public function index() {
        $totalPlayStation = PlayStation::count();
        $totalIncome = GameLogs::where('status_permainan', 'berakhir')
                        ->sum('total_price');


        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        // dd($startOfMonth, $endOfMonth);

        // Query untuk menghitung jumlah order costumer pada minggu ini
        $totalOrdersThisMonth = GameLogs::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                ->where('status_permainan', 'berakhir')
                                ->count();
        // dd($totalOrdersThisMonth);

        $berdasarkanTypePs = PlayStation::selectRaw('name, count(*) as count')
                                ->groupBy('name')
                                ->get();
        // dd($berdasarkanTypePs[0]);


        $totalPlayStationPerMonth = GameLogs::selectRaw('MONTHNAME(start_time) as bulan, count(*) as count')
                    ->where('status_permainan', '!=' , 'bermain')
                    ->groupBy('bulan')
                    ->get();
        // dd($totalPlayStationPerMonth);

        $totalIncomePerMonth = GameLogs::selectRaw('YEAR(created_at) as tahun, MONTHNAME(created_at) as bulan, SUM(total_price) as total_pendapatan')
                    ->where('status_permainan', '!=' , 'bermain')
                    ->groupByRaw('YEAR(created_at), MONTHNAME(created_at)')
                    ->get();
        // dd($totalIncomePerMonth);


        // Query untuk menghitung total order masuk pada setiap minggu pada bulan ini
        // $totalOrdersPerWeek = GameLogs::whereBetween('created_at', [$startOfMonth, $endOfMonth])
        //                              ->where('status_permainan', '!=' , 'bermain')
        //                              ->selectRaw('WEEK(created_at) as setiapMinggu, count(*) as total_orders')
        //                              ->groupBy('setiapMinggu')
        //                              ->get();
        // dd($totalOrdersPerWeek);


        return response()->json([
            'totalPlayStation' => $totalPlayStation,
            'totalIncome' =>  $totalIncome,
            'totalOrdersThisMonth' => $totalOrdersThisMonth,
            'berdasarkanType' => $berdasarkanTypePs,
            'totalOrdersPlayStationPerMonth' => $totalPlayStationPerMonth,
            'totalIncomePerMonth' => $totalIncomePerMonth
        ], 200);
    }
}
