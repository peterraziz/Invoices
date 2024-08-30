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
        // بتجيبلي اجمالي عدد الفواتير يعني كام فاتورة count فانكشن
        $count = invoices::count();
        
        // بتجيبلي اجمالي قيمة الفواتير sum فانكشن
        $sum = invoices::sum('Total');
        
        // بتنظملي الرقم بعلامات عشرية number_format فانكشن
        $number_format = number_format($sum, 2);
        

        // إجمالي الفواتير الغير مدفوعة
        $not_payed_sum = invoices::where('Value_Status', 2)->sum('Total');
        $not_payed = number_format($not_payed_sum, 2);
        $count_not_payed = invoices::where('Value_Status', 2)->count();
        // % نسبتهم كام من اجمالي عدد الفواتير كلها 
        // $total_not_payed = $count_not_payed / $count *100;
        // $total_not_payed = round($count_not_payed / $count *100);
        $total_not_payed = $count > 0 ? round($count_not_payed / $count * 100) : 0; //Edited-new 
        


        // إجمالي الفواتير المدفوعة
        $payed_sum = invoices::where('Value_Status', 1)->sum('Total');
        $payed = number_format($payed_sum, 2);
        $count_payed = invoices::where('Value_Status',1)->count();
        // % نسبتهم كام من اجمالي عدد الفواتير كلها 
        // $total_payed = round($count_payed / $count *100); 
        $total_payed = $count > 0 ? round($count_payed / $count * 100) : 0; //Edited-new
        
        // إجمالي الفواتير المدفوعة جزئيا
        $payed_half_sum = invoices::where('Value_Status', 3)->sum('Total');
        $half_payed = number_format($payed_half_sum, 2);
        $count_half_payed = invoices::where('Value_Status',3)->count();
        // % نسبتهم كام من اجمالي عدد الفواتير كلها 
        // $total_half_payed = round($count_half_payed / $count *100);
        $total_half_payed = $count > 0 ? round($count_half_payed / $count * 100) : 0;//Edited-new



/////////////////////////////   Package chartjs   ///////////////////////////////////

    if($count_not_payed == 0){
        $total_not_payed=0;
    }
    else{
        $total_not_payed;
    }

        if($count_payed == 0){
            $total_payed=0;
        }
        else{
            $total_payed;
        }

        if($count_half_payed == 0){
            $total_half_payed=0;
        }
        else{
            $total_half_payed;
        }

//                     
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 490, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$total_not_payed]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$total_payed]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$total_half_payed]
                ],
            ])
            ->options([]);
//
        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$total_not_payed, $total_payed, $total_half_payed]
                ]
            ])
            ->options([]); 


        return view('home', compact('number_format', 'sum', 'count', 'count_not_payed',
                                'not_payed', 'total_not_payed', 'payed_sum', 'payed',
                                'count_payed', 'total_payed', 'payed_half_sum', 'half_payed',
                                'count_half_payed', 'total_half_payed', 'chartjs','chartjs_2'));    
        // وممكن اعملها من فايل البليد علي طول من أول جزء: إجمالي الفواتير 
        
    }
}
