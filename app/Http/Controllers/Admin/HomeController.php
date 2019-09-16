<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use App\OrderDetail;
class HomeController extends Controller {

    public function __construct() {
        $this->middleware('admin.auth')->except('logout');
    }

    public function index() 
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        if(request()->has('fromDate') && request()->has('toDate'))
        {
            $formdate1 = request('fromDate');
            $formdate = date("Y-m-d", strtotime($formdate1));
            $todate1 = request('toDate');
            $todate = date("Y-m-d", strtotime($todate1));
            $orders = Order::getPendingOrdersdashboard($formdate,$todate);
            $ordersYear = Order::whereBetween('created_at', [$formdate,$todate])->get();
            $ordersYearSale = Order::getYearsSalesdashboard($formdate,$todate);
            $orderMonthlySales1 = Order::getMonthlyOrdersSortDate($formdate,$todate);
            $orderMonthlySales = $this->buildArrayforSortDateChart($orderMonthlySales1,$formdate,$todate);
           
        }
        else
        {
            $orders = Order::getPendingOrders();
            $ordersYear = Order::whereYear('created_at', '=', $currentYear)->get();
            $ordersYearSale = Order::getYearsSales($currentYear);
            $orderMonthlySales1 = Order::getMonthlyOrdersThisYear();  
            $orderMonthlySales =$this->buildArrayforChart($orderMonthlySales1,$currentYear) ;
        }
        $totalMonthSubscriptionOrder = OrderDetail::whereYear('created_at', '=', $currentYear)->whereMonth('created_at', '=', $currentMonth)->whereNotNull('subscription_id')->get();
        $totalDirectSubscriptionOrder = OrderDetail::whereYear('created_at', '=', $currentYear)->whereMonth('created_at', '=', $currentMonth)->whereNull('subscription_id')->get();
        $totalMonthOrder = Order::whereYear('created_at', '=', $currentYear)->whereMonth('created_at', '=', $currentMonth)->get();
        $ordersMonthSale = Order::getMonthSales($currentMonth, $currentYear);
        return view('admin.home.home', [
            'orders' => $orders,
            'totalMonthOrder' => $totalMonthOrder,
            'totalMonthSubscriptionOrder' => $totalMonthSubscriptionOrder,
            'totalDirectSubscriptionOrder' => $totalDirectSubscriptionOrder,
            'ordersYear'=>$ordersYear,
            'ordersYearSale'=> $ordersYearSale,
            'ordersMonthSale'=> $ordersMonthSale,
            'orderMonthlySales' => $orderMonthlySales
        ]);
    }
    private function buildArrayforChart($orderMonthlySales,$currentYear)
    {
        $data1= [];
        $data = [];
        $monthNames = ["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"];

        foreach($monthNames as $key=>$month)
        {
            $data1[$month] =  [strtotime($currentYear.'-'.($key+1).'-01')*1000,0];
        }
        foreach($orderMonthlySales as $sale)
        {
            $data1[strtolower(date("M",strtotime($sale->created_at)))] = [strtotime($sale->created_at)*1000,$sale->total_order];
        }
    
        foreach($monthNames as $key=>$month)
        {
            $data[] =  $data1[$month];
        }
        return $data;
    }
    private function buildArrayforSortDateChart($orderMonthlySales,$formdate,$todate)
    {
        $data1= [];
        $data = [];
        $leftMonth = [];
        $formYear = date("Y", strtotime($formdate));
        $formMonth = date("m", strtotime($formdate));
        $toYear = date("Y", strtotime($todate));
        $toMonth = date("m", strtotime($todate));

        $monthNames = ["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"];
        foreach($monthNames as $key=>$month)
        {
            if($key+1 >= $formMonth)
            {
                $data1[$month.'-'.$formYear] =  [strtotime($formYear.'-'.($key+1).'-01')*1000,0];
            }
            else
            {
                $leftMonth[$month]=$key+1 ;
            }
        }    
        foreach($leftMonth as $key=>$month)
        {
            
            $data1[$key.'-'.($formYear+1)] =  [strtotime(($formYear+1).'-'.($month).'-01')*1000,0];
        }
        foreach($orderMonthlySales as $sale)
        {
            $data1[strtolower(date("M-Y",strtotime($sale->created_at)))] = [strtotime($sale->created_at)*1000,$sale->total_order];
        }
        foreach($data1 as $month)
        {
            $data[] =  $month;
        }
        return $data;
    }
}
