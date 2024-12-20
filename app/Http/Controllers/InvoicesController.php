<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Http\Requests\StoreinvoicesRequest;
use App\Http\Requests\UpdateinvoicesRequest;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use App\Models\products;
use App\Models\sections;
use App\Models\User as ModelsUser;
use App\Notifications\AddNotifications;
use App\Notifications\Add_invoices_new;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;


class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoices = invoices::all();
        // dd($invoices);
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sections = sections::all();
        $products = products::all();
        // dd($products);

        return view('invoices.add_invoice', compact('sections','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreinvoicesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $invoic = invoices::create([

            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request?->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعه',
            'Value_Status' => 2,
            'note' => $request->note,

        ]);


        // ===================
        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request?->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),


        ]);
        // return $request;
        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        // لو انا عاوز ابعت اشعار لكل المستخدمين عي السستم
        // $user = User::get();
        // $user = Auth::user();

        // $invoices = invoices::latest()->first();
        // Notification::send($user, new \App\Notifications\AddNotifications($invoices));

        // $invoice->notify(new AddNotifications($messages));

        // $user = User::find(Auth::user()->id);دا لو انا عاوز ابعت اشعار للمستخدم الموجود في عمليه الدخول حاليا
        // Notification::send($user, new \App\Notifications\Add_invoices_new($invoices));

        $user = ModelsUser::get();
        $invoices = invoices::latest()->first();
        Notification::send($user, new Add_invoices_new($invoices));


        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return redirect('/invoices');
    }

  public function markAsRead(){

        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back();

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();

        // return [$id,$invoices];
        return view('invoices.status_invoices', compact('invoices'));
    }
    public function Status_Update($id, Request $request)
    {
        // return ($request);
        $invoices = invoices::findOrFail($id);


        // return [$id,$request ,$invoices];
        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'invoice_id' => $id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'invoice_id' => $id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        $invoices = invoices::all();
        session()->flash('Status_Update');
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $invoices  = invoices::where('id', $id)->first();
        $sections = sections::all();
        // return $id;
        return view('invoices.edit_invoice', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateinvoicesRequest  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $invoice_id = $request->invoice_id;

        // return $invoic;
        // ===========================
        invoices::where('id', $invoice_id)->update([

            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعه',
            'Value_Status' => 2,
            'note' => $request->note,

        ]);


        // ===================
        // $invoice_id = invoices::latest()->first()->id;
        invoices_details::where('id', $invoice_id)->update([
            // 'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),


        ]);
        // return $request;
        // if ($request->hasFile('pic')) {

        //     // $invoice_id = Invoices::latest()->first()->id;
        //     $image = $request->file('pic');
        //     $file_name = $image->getClientOriginalName();
        //     $invoice_number = $request->invoice_number;

        //     $attachments = new invoice_attachments();
        //     $attachments->file_name = $file_name;
        //     $attachments->invoice_number = $invoice_number;
        //     $attachments->Created_by = Auth::user()->name;
        //     $attachments->invoice_id = $invoice_id;
        //     $attachments->save();

        //     // move pic
        //     $imageName = $request->pic->getClientOriginalName();
        //     $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        // }
        $invoices = invoices::all();

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return view('invoices.invoices', compact('invoices'));
        // ===========================

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoice_attachments::where('invoice_id', $id)->first();

        $id_page = $request->id_page;
        if (!$id_page == 2) {

            if (!empty($Details->invoice_number)) {

                Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
            }

            $invoices->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');
        } else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/archive');
        }
        // $invoices->delete();
        // session()->flash('delete_invoice');
        // return redirect('/invoices');
    }
    public function getproducts($id)
    {
        //
        // dd('fun',$id);
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        // return json_encode($products);
        return response()->json($products);
    }

    public function paid()
    {
        $invoices = invoices::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }
    public function unpaid()
    {
        $invoices = invoices::where('Value_Status', 2)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }
    public function partial()
    {
        $invoices = invoices::where('Value_Status', 3)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }

    public function print($id)
    {

        $invoices  = invoices::where('id', $id)->first();

        return view('invoices.invoice_print', compact('invoices'));
    }
}
