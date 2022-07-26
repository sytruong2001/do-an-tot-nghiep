<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CheckOutModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class revenueController extends Controller
{
    public function index(Request $request)
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::today()->addDay(1);
        if ($request->get('end_date') && $request->get('start_date')) {
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            $checkout = CheckOutModel::select(DB::raw("SUM(sum_price) as rev"), DB::raw("Date(time_end) as day_name"))
                ->whereYear('time_end', date('Y'))
                ->whereDate('time_end', '>=', $start_date)
                ->whereDate('time_end', '<=', $end_date)
                ->groupBy(DB::raw("Date(time_end)"))
                ->pluck('rev', 'day_name');
            $labels = $checkout->keys();
            $data = $checkout->values();
            $datas = [
                'labels' => $labels,
                'data' => $data,
            ];
            return response()->json(['checkout' => $checkout, 'datas' => $datas, 'labels' => $labels, 'data' => $data]);
            // return response()->json(['start' => $start_date, 'end' => $end_date]);
        } else {
            $checkout = CheckOutModel::select(DB::raw("SUM(sum_price) as rev"), DB::raw("Date(time_end) as day_name"))
                ->whereYear('time_end', date('Y'))
                ->where([
                    ['time_end', '>=', $start_date],
                    ['time_end', '<=', $end_date],
                ])
                ->groupBy(DB::raw("Date(time_end)"))
                ->pluck('rev', 'day_name');
        }


        $labels = $checkout->keys();

        $data = $checkout->values();

        $datas = [
            'labels' => $labels,
            'data' => $data,
        ];
        return view('super-admin.view_revenue', [
            'datas' => $datas, 'checkout' => $checkout,
        ], compact('labels', 'data'));
    }
}