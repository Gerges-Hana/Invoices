<?php

namespace App\Http\Controllers;

use App\Models\archive;
use App\Http\Requests\StorearchiveRequest;
use App\Http\Requests\UpdatearchiveRequest;
use App\Models\invoices;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoices = invoices::onlyTrashed()->get();
        return view('invoices.invoices_archive', compact('invoices'));
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
     * @param  \App\Http\Requests\StorearchiveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorearchiveRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function show(archive $archive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function edit(archive $archive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatearchiveRequest  $request
     * @param  \App\Models\archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $id = $request->invoice_id;
        $deletedInvices = invoices::withTrashed()->where('id', $id)->first();
        $deletedInvices->restore();
        session()->flash('archive_invoice');
        return redirect('/archive');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = invoices::withTrashed()->where('id', $id)->first();
        if ($invoice) {
            $invoice->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/archive');

        } else {
            session()->flash('notdelete_invoice');
            return redirect('/archive');
        }
    }
}
