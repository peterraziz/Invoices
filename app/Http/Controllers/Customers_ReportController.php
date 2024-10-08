<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices as ModelsInvoices;
use App\Models\sections as ModelsSections;

class Customers_ReportController extends Controller
{
    public function index(){

    $sections = ModelsSections::all();
    return view('reports.customers_report',compact('sections'));
    
    }

    public function Search_customers(Request $request){
// في حالة البحث بدون التاريخ
    
    if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {

    
    $invoices = ModelsInvoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
    $sections = ModelsSections::all();
    return view('reports.customers_report',compact('sections'))->withDetails($invoices);

    }

// في حالة البحث بتاريخ
    
    else {
    
    $start_at = date($request->start_at);
    $end_at = date($request->end_at);

    $invoices = ModelsInvoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
    //  whereBetween معناها بين تاريخين
    $sections = ModelsSections::all();
    return view('reports.customers_report',compact('sections'))->withDetails($invoices);

    }
    
    }
}