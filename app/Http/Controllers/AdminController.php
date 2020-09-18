<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\CarbonPeriod;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $date_range = (!empty($request->d_range)) ? $request->d_range : 7;
        if ($request->d_range > 30) {
            return redirect()->route('admin.dashboard');
        }
        $period  = CarbonPeriod::create(now()->subDays($date_range), now());
        $first_day = $period->first()->format('Y-m-d');
        $today = now()->format('Y-m-d');
        $orders = Order::where('status', Order::STT['completed'])
            ->whereBetween('created_at', [date($first_day), date($today)])
            ->pluck('id');
        $date_chart = \DB::table('order_details as d')
            ->whereIn('d.order_id', $orders)
            ->join('orders as o', 'd.order_id', '=', 'o.id')
            ->select(\DB::RAW('
                DATE(o.created_at) AS date,
                SUM(d.quantity_ordered) AS sales_lw,
                SUM(d.quantity_ordered * d.price) AS amount_lw
            '))
            ->groupBy('date')
            ->get();
        $range = $date_each = $sales = $amount = [];
        $i = $max_sale = $max_amount = 0;
        foreach ($period as $k => $v) {
            $range[] = '"' . $v->format('d/m') . '"';
            $date_each[$i] = null;
            foreach($date_chart->all() as $k1 => $v1) {
                if ($v->format('Y-m-d') == $v1->date) {
                    $date_each[$i] = $v1;
                } else {
                    continue;
                }
            }
            if ($date_each[$i] !== null && $max_sale < $date_each[$i]->sales_lw) {
                $max_sale = $date_each[$i]->sales_lw;
            }
            if ($date_each[$i] !== null && $max_amount < $date_each[$i]->amount_lw) {
                $max_amount = round($date_each[$i]->amount_lw, -3);
            }
            $sales[] = ($date_each[$i] !== null) ? '"' . $date_each[$i]->sales_lw . '"' : '"0"';
            $amount[] = ($date_each[$i] !== null) ? '"' . $date_each[$i]->amount_lw . '"' : '"0"';
            $i++;
        }
        $date = implode(',', $range);
        $sales = implode(',', $sales);
        $amount = implode(',', $amount);

        $order_product = \DB::table('order_details AS od')
            ->join('products AS p', 'od.product_id', '=', 'p.id')
            ->whereIn('od.order_id', $orders)
            ->select('od.id', 'od.quantity_ordered', 'od.price', 'p.brand_id');
        $brand_chart = \DB::table('brands AS b')
            ->leftJoinSub($order_product, 'orders', function($join){
                $join->on('b.id', '=', 'orders.brand_id');
            })
            ->select('b.id', 'b.name', \DB::RAW('
                SUM(orders.quantity_ordered) AS brand_sales,
                SUM(orders.quantity_ordered * orders.price) AS brand_amount
            '))
            ->groupBy('b.id', 'b.name')
            ->get();

        $brands = $brand_sale = $brand_amount = [];
        $max_brand_sale = $max_brand_amount = $total_sales = $total_amount = 0;

        foreach ($brand_chart as $brand) {
            $brands[] = '"' . $brand->name . '"';
            $brand_sale[] = ($brand->brand_sales !== null) ? '"' . $brand->brand_sales . '"' : '"0"';
            $brand_amount[] = ($brand->brand_amount !== null) ? '"' . $brand->brand_amount . '"' : '"0"';

            if ($brand->brand_sales !== null ) {
                $total_sales += $brand->brand_sales;
                if ($max_brand_sale < $brand->brand_sales) {
                    $max_brand_sale = $brand->brand_sales;
                }
            }

            if ($brand->brand_amount !== null) {
                $total_amount += $brand->brand_amount;
                if ($max_brand_amount < $brand->brand_amount) {
                    $max_brand_amount = round($brand->brand_amount, -3);
                }
            }
        }

        $brands = implode(',', $brands);
        $brand_sale = implode(',', $brand_sale);
        $brand_amount = implode(',', $brand_amount);

        $top_products = \DB::table('order_details AS od')
            ->whereIn('od.order_id', $orders)
            ->join('products AS p', 'od.product_id', '=', 'p.id')
            ->select('od.product_id', 'p.name', \DB::RAW('
                SUM(od.quantity_ordered) AS sales
            '))
            ->groupBy('product_id')
            ->orderBy('sales', 'desc')
            ->take(10)
            ->get();

        return view('admin_def.pages.index', compact(
            'date_range', 'total_sales', 'total_amount',
            'date', 'sales', 'amount', 'max_sale', 'max_amount',
            'brands', 'brand_sale', 'brand_amount', 'max_brand_sale', 'max_brand_amount',
            'top_products'
        ));
    }

    public function page404()
    {
        return response()->view('admin_def.pages.404', [], 404);
    }

    public function login()
    {
        return view('admin_def.pages.login');
    }

    public function contact()
    {
        return view('admin_def.pages.contact');
    }

    public function footer()
    {
        return view('admin_def.page.footer');
    }
}
