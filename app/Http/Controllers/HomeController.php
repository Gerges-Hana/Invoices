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

    //    الفواتير  مدفوعه

    $all_sum_paid= number_format(invoices::where('Value_Status',1)->sum('Total'), 2);
    $all_count_paid= invoices::where('Value_Status',1)->count();

    //   جزئيا الفواتير  مدفوعه

    $all_sum_partial= number_format(invoices::where('Value_Status',3)->sum('Total'), 2);
    $all_count_partial= invoices::where('Value_Status',3)->count();



        return view('home',compact('all_sum','all_count','all_sum_unpaid','all_count_unpaid','all_sum_paid','all_count_paid','all_sum_partial','all_count_partial'));
    }
}
