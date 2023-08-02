<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\invoices;
use Illuminate\Http\Request;

class invoices_report extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reports.invoices_report');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Search_invoices(Request $request)
    {
        //
    //    return $request;
       $rdio = $request->rdio;


       // في حالة البحث بنوع الفاتورة

          if ($rdio == 1) {


       // في حالة عدم تحديد تاريخ
              if ($request->type && $request->start_at =='' && $request->end_at =='') {

                if($request->type=='جميع الفواتير'){

                    $invoices = invoices::all();
                    $type = $request->type;
                    // return view('reports.invoices_report', compact('type'))->with('invoices', $invoices);
                    return view('reports.invoices_report',compact('invoices'))->withDetails($type);

                }else{


                 $invoices = invoices::select('*')->where('Status','=',$request->type)->get();
                 $type = $request->type;
                 return view('reports.invoices_report',compact('invoices'))->withDetails($type);

                }
                }

              // في حالة تحديد تاريخ استحقاق
              else {

                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
                return view('reports.invoices_report',compact('invoices','start_at','end_at'))->withDetails($type);

              }



          }

      //====================================================================

      // في البحث برقم الفاتورة
          else {

              $invoices = invoices::select('*')->where('invoice_number','=',$request->invoice_number)->get();
              return view('reports.invoices_report',compact('invoices'));

          }




    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
