<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Option;
use App\Traits\CartTrait;
use App\Traits\UserTrait;
use function GuzzleHttp\json_decode;

class FrontpageController extends Controller
{
    use CartTrait;

    use UserTrait;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $cart = session()->get('cart');
            if (!empty($cart)) {
                $products = $this->getCartDetails();
                View::share('cart', [
                    'count' => count($cart),
                    'total' => $products['total'],
                ]);
            }
            return $next($request);
        });

        $menuList = $brands = [];
        $options = Option::where('parent_id', '<>', null)->get()->mapWithKeys(function($items){
            return [$items->key => $items->value]; 
        });

        $images = DB::table('product_images')
            ->select('product_id', 'image')
            ->whereRaw('id IN (SELECT min(id) AS id from product_images GROUP BY product_id)');
        if (!empty($options['menu'])) {
        $option_menu = json_decode($options['menu']);
            if (!empty($option_menu)) {
                $menu_items = array_keys(get_object_vars($option_menu));
                $brands = DB::table('brands')->whereIn('slug', $menu_items)->select('id', 'name')->get();
                
                foreach ($brands->all() as $menu) {
                    $products = DB::table('products AS p')
                        ->where('brand_id', $menu->id)
                        ->joinSub($images, 'image', function($join) {
                            $join->on('p.id', '=', 'image.product_id');
                        })
                        ->select('p.id', 'name', 'current_price', 'brand_id', 'image.image')
                        ->orderBy('p.id', 'desc')
                        ->take(12)
                        ->get();
                    if (count($products) > 0) {
                        $menuList[$menu->name] = $products;
                    }
                }
                $others = DB::table('brands')->whereNotIn('slug', $menu_items)->get();
            }
        } else {
            $others = DB::table('brands')->get();
        }

        $menuList['others'] = DB::table('products AS p')
            ->whereIn('brand_id', $others->pluck('id'))
            ->joinSub($images, 'image', function($join) {
                $join->on('p.id', '=', 'image.product_id');
            })
            ->select('p.id', 'name', 'current_price', 'brand_id', 'image.image')
            ->orderBy('p.id', 'desc')
            ->take(12)
            ->get();
       
        View::share(compact('menuList', 'others', 'options'));
    }

    public function home()
    {
        $new_arrival = Product::with('thumb', 'brand:id,name')->orderBy('id', 'desc')->take(10)->get();
        $products = Product::with('thumb', 'brand:id,name')->whereNotIn('id', $new_arrival->pluck('id'))->orderBy('id', 'desc')->paginate(24);

        $bs_orders = Order::where('status', Order::STT['completed'])->pluck('id');
        $bs_products = DB::table('order_details')
            ->select('product_id', DB::RAW('product_id, sum(quantity_ordered) AS total'))
            ->whereIn('order_id', $bs_orders)
            ->groupBy('product_id')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();
        $best_sellers = Product::with('thumb', 'brand:id,name')->find($bs_products->pluck('product_id'));
        return view('frontpage_def.pages.index', compact('products', 'best_sellers', 'new_arrival'));
    }

    public function brand($id)
    {
        $products = Product::with('thumb', 'brand:id,name')->where('brand_id', $id)->paginate(12);
        return view('frontpage_def.pages.product_list', compact('products'));
    }

    public function productDetails($id)
    {
        $product = Product::with('images', 'brand:id,name')->findOrFail($id);
        $relates = Product::with('thumb', 'brand:id,name')->where('brand_id', $product->brand_id)->where('id', '<>', $product->id)->take(10)->get();
        return view('frontpage_def.pages.product_details', compact('product', 'relates'));
    }

    public function about()
    {
        return view('frontpage_def.pages.about');
    }

    public function contact()
    {
        return view('frontpage_def.pages.contact');
    }

    public function checkout()
    {
        $cart = session()->get('cart');
        if (!empty($cart)) {
            $products = Product::with('images')->find($cart);
            $total = $products->sum('current_price');
            $quantity = session()->get('cart-quantity');
            if (!empty($quantity)) {
                foreach ($quantity as $key => $value) {
                    foreach($products as $product) {
                        if ($product->id === $key) {
                            $product->quantity = $value;
                            $total += $product->current_price * ($value - 1);
                        }
                    }
                }
            }
            return view('frontpage_def.pages.checkout', compact('products', 'total'));
        }
        return redirect()->back();
    }

    public function cart()
    {
        $cart = session()->get('cart');
        if (!empty($cart)) {
            $products = Product::with('images')->find($cart);
            return view('frontpage_def.pages.cart', compact('products'));
        } else {
            return view('frontpage_def.pages.cart');
        }
    }

    public function login()
    {
        return view('frontpage_def.pages.user_login');
    }

    public function register()
    {
        return view('frontpage_def.pages.user_register');
    }

    public function search()
    {
        return view('frontpage_def.pages.search');
    }

    public function searchSubmit(Request $request)
    {
        if ($request->q !== null) {
            $products = Product::where('name', 'like', "%$request->q%")
                ->orderBy('id', 'desc')
                ->paginate(20)
                ->appends([
                    'q' => $request->q,
                ]);
            
            if (count($products) > 0) {
                $total = $products->total();
                $fromResult = ($products->currentPage() - 1) * $products->perPage() + 1;
                $toResult = $products->currentPage() !== $products->lastPage() ? $products->currentPage() * $products->perPage() : $total; 
                return view('frontpage_def.pages.search', compact('products', 'fromResult', 'toResult', 'total'));
            }
        }
        return view('frontpage_def.pages.blank');
    }

    public function userAccount()
    {
        $user = Auth::check() ? Auth::user() : null;
        return view('frontpage_def.pages.user_account', compact('user')); 
    }

    public function userEditProfile($id)
    {
        $user = Auth::check() ? Auth::user() : null;
        return view('frontpage_def.pages.user_edit_profile', compact('user'));
    }

    public function userUpdateProfile(Request $request)
    {
        $user = Auth::user();
        if (!empty($user)) {
            $profile = User::find($user->id);
            $profile->fill($request->all());
            if ($profile->save()) {
                return redirect()->route('user.account');
            }
        }
        return redirect()->back()->withInput();
    }

    public function userOrderIndex()
    {
        $user = Auth::user();
        $orders = $this->getOrders($user);
        return view('frontpage_def.pages.user_orders', compact('user', 'orders'));
    }

    public function userOrderShow($id)
    {
        $user = Auth::user();
        $order = $this->getOrderDetails($id);
        return view('frontpage_def.pages.user_order_details', compact('user', 'order'));
    }

    public function userBillIndex()
    {
        $user = Auth::user();
        $bills = $this->getBills($user);
        return view('frontpage_def.pages.user_billing', compact('user', 'bills'));
    }

    public function userBillShow($id)
    {
        $user = Auth::user();
        $bill = $this->getOrderDetails($id);
        return view('frontpage_def.pages.user_bill_details', compact('user', 'bill'));
    }
}
