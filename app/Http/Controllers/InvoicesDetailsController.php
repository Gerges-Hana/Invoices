<?php

namespace App\Http\Controllers;

use App\Models\invoices_details;
use App\Http\Requests\Storeinvoices_detailsRequest;
use App\Http\Requests\Updateinvoices_detailsRequest;
use App\Models\invoice_attachments;
use App\Models\invoices;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storeinvoices_detailsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeinvoices_detailsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $invoices=invoices::where('id',$id)->first();
        $details=invoices_details::where('invoice_id',$id)->get();
        $attachments=invoice_attachments::where('invoice_id',$id)->get();
        // return [$details,$attachments,$invoices];
        return view('invoices.invoices_details',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateinvoices_detailsRequest  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Updateinvoices_detailsRequest $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices_details $invoices_details)
    {
        //
    }
}
