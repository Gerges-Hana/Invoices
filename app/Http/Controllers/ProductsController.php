<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Http\Requests\StoreproductsRequest;
use App\Http\Requests\UpdateproductsRequest;
use App\Models\Product;
use App\Models\sections;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sections=sections::all();
        $products=products::all();
        // $products = products::with('section')->get();
        return view('products.products',compact('sections','products'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Product_name
        // section_id
        // description

        $validatedData = $request->validate([
            'Product_name' => 'required|unique:products|max:255',
            'section_id' => 'required',
            'description' => 'string',
        ],[
            'Product_name.required' =>'يرجي ادخال اسم المنتج',
            'Product_name.unique' =>'اسم المنتج مسجل مسبقا',
            'section_id.required' =>'يرجي اختيار قسم ',
            'description.string' => 'يجب ان يكون الوصف يحتوي عي نص ',
        ]);

        $product=products::create([
        'Product_name'=>$request->Product_name,
        'section_id'=>$request->section_id,
        'description'=>$request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
            return redirect('/products');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateproductsRequest  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $id_v=$request->id;

        $validatedData = $request->validate([
            'Product_name' => 'required|unique:products|max:255'.$id_v,
            // 'section_id' => 'required',
            'description' => 'string',
        ],[
            'Product_name.required' =>'يرجي ادخال اسم القسم',
            'Product_name.unique' =>'اسم القسم مسجل مسبقا',
            // 'section_id.required' =>'يرجي اختيار قسم ',
            'description.string' => 'يجب ان يكون الوصف يحتوي عي نص ',
        ]);

        $id = sections::where('section_name', $request->section_name)->first()->id;

        $Products = Products::findOrFail($request->pro_id);

        $Products->update([
        'Product_name' => $request->Product_name,
        'description' => $request->description,
        'section_id' => $id,
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        // dd($request);
        $id=$request->id;
        products::find($id)?->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
