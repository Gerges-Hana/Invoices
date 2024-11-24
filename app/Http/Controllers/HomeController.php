<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // الفواتير  اجمالي
       $all_sum= number_format(invoices::sum('Total'), 2);
       $all_count= invoices::count();

    //    الفواتير الغير مدفوعه

    $all_sum_unpaid= number_format(invoices::where('Value_Status',2)->sum('Total'), 2);
    $all_count_unpaid= invoices::where('Value_Status',2)->count();
    $per_unpaid=round($all_count_unpaid /   2*100,2);
    // $per_unpaid=round($all_count_unpaid /  $all_count *100,2);

    //    الفواتير  مدفوعه

    $all_sum_paid= number_format(invoices::where('Value_Status',1)->sum('Total'), 2);
    $all_count_paid= invoices::where('Value_Status',1)->count();
    $per_paid=round($all_count_paid /  2 *100,2);
    // $per_paid=round($all_count_paid /  $all_count *100,2);

    //   جزئيا الفواتير  مدفوعه

    $all_sum_partial= number_format(invoices::where('Value_Status',3)->sum('Total'), 2);
    $all_count_partial= invoices::where('Value_Status',3)->count();
    $per_partial=round($all_count_partial /  2 *100,2);
// ==========================================
// $chartjs = app()->chartjs
//         ->name('lineChartTest')
//         ->type('line')
//         ->size(['width' => 400, 'height' => 200])
//         ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
//         ->datasets([
//             [
//                 "label" => "My First dataset",
//                 'backgroundColor' => "rgba(38, 185, 154, 0.31)",
//                 'borderColor' => "rgba(38, 185, 154, 0.7)",
//                 "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
//                 "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
//                 "pointHoverBackgroundColor" => "#fff",
//                 "pointHoverBorderColor" => "rgba(220,220,220,1)",
//                 'data' => [65, 59, 80, 81, 56, 55, 40],
//             ],
//             [
//                 "label" => "My Second dataset",
//                 'backgroundColor' => "rgba(38, 185, 154, 0.31)",
//                 'borderColor' => "rgba(38, 185, 154, 0.7)",
//                 "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
//                 "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
//                 "pointHoverBackgroundColor" => "#fff",
//                 "pointHoverBorderColor" => "rgba(220,220,220,1)",
//                 'data' => [12, 33, 44, 44, 55, 23, 40],
//             ]
//         ])
//         ->options([]);

// return view('example', compact(''));
// ==========================================
$chartjs2 = app()->chartjs
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 400, 'height' => 200])
         ->labels(['الفواتير الغير مدفوعه', ' الفواتير المدفوعه جزئيا','الفواتير المدفوعه'])
         ->datasets([
             [
                 "label" => "الفواتير الغير مدفوعه",
                 'backgroundColor' => ['#f94160'],
                 'data' => [$per_unpaid]
             ],
             [
                 "label" => "الفواتير المدفوعه جزئيا",
                 'backgroundColor' => ['#f76d2f'],
                 'data' => [$per_partial]
             ]
             ,
             [
                 "label" => "الفواتير المدفوعه ",
                 'backgroundColor' => ['#0c9f6f'],
                 'data' => [ $per_paid]
             ]
         ])
         ->options([]);

// ==========================================
$chartjs3 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['الفواتير الغير مدفوعه', ' الفواتير المدفوعه جزئيا','الفواتير المدفوعه'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#f76d2f','#0c9f6f'],
                'hoverBackgroundColor' => ['#FF6384', '#f76d2f','#0c9f6f'],
                'data' => [$per_unpaid, $per_partial,$per_paid]
            ]
        ])
        ->options([]);

// ==========================================


        return view('home',compact('chartjs2','chartjs3','all_sum','all_count','all_sum_unpaid','all_count_unpaid','all_sum_paid','all_count_paid','all_sum_partial','all_count_partial','per_partial','per_paid','per_unpaid'));
    }
}
