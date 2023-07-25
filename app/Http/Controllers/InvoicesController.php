<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Http\Requests\StoreinvoicesRequest;
use App\Http\Requests\UpdateinvoicesRequest;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $invoices=invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sections=sections::all();

         return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreinvoicesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//         "_token": "esTWTUtmSttzuxG7RdH1O1U9cZSrPWPhH471VNNF",
// "invoice_number": "9876",
// "invoice_Date": "2023-07-24",
// "Due_date": "2023-07-10",
// "Section": "1",
// "product": "قرض تجاري",
// "Amount_collection": "10000",
// "Amount_Commission": "9000",
// "Discount": "1000",
// "Rate_VAT": "5%",
// "Value_VAT": "400.00",
// "Total": "8400.00",
// "note": "حهتحههتمت",
// "pic": {}
// ===================
$invoic=invoices::create([

    'invoice_number'=>$request->invoice_number ,
    'invoice_Date'=>$request->invoice_Date ,
    'Due_date'=>$request->Due_date ,
    'product'=>$request->product ,
    'section_id'=>$request->Section ,
    'Amount_collection'=>$request->Amount_collection ,
    'Amount_Commission'=>$request->Amount_Commission ,
    'Discount'=>$request->Discount ,
    'Value_VAT'=>$request->Value_VAT ,
    'Rate_VAT'=>$request->Rate_VAT ,
    'Total'=>$request->Total ,
    'Status'=>'غير مدفوعه' ,
    'Value_Status'=>2 ,
    'note'=>$request->note ,

]);


// ===================
$invoice_id = invoices::latest()->first()->id;
invoices_details::create([
    'invoice_id' => $invoice_id,
    'invoice_number' => $request->invoice_number,
    'product' => $request->product,
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

session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
return back();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(invoices $invoices)
    {
        //
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
        $invoices=invoices::where('id',$id)->first();
        $sections=sections::all();
        // return $id;
       return view('invoices.edit_invoice',compact('invoices','sections'));
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
        $invoice_id=$request->invoice_id;

        // return $invoic;
        // ===========================
        invoices::where('id',$invoice_id)->update([

            'invoice_number'=>$request->invoice_number ,
            'invoice_Date'=>$request->invoice_Date ,
            'Due_date'=>$request->Due_date ,
            'product'=>$request->product ,
            'section_id'=>$request->Section ,
            'Amount_collection'=>$request->Amount_collection ,
            'Amount_Commission'=>$request->Amount_Commission ,
            'Discount'=>$request->Discount ,
            'Value_VAT'=>$request->Value_VAT ,
            'Rate_VAT'=>$request->Rate_VAT ,
            'Total'=>$request->Total ,
            'Status'=>'غير مدفوعه' ,
            'Value_Status'=>2 ,
            'note'=>$request->note ,

        ]);


        // ===================
        // $invoice_id = invoices::latest()->first()->id;
        invoices_details::where('id',$invoice_id)->update([
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
        if ($request->hasFile('pic')) {

            // $invoice_id = Invoices::latest()->first()->id;
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

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return view('invoices.invoices');
        // ===========================

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices $invoices)
    {
        //
    }
    public function getproducts($id)
    {
        //
        // dd('fun',$id);
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        // return json_encode($products);
        return response()->json($products);
    }
//     public function getBySection($sectionId)
// {
//     // استخراج المنتجات التي تنتمي إلى القسم المحدد
//     $products = DB::table('products')->where('section_id', $sectionId)->get();

//     // إعادة البيانات في شكل JSON
//     return response()->json($products);
// }



}
