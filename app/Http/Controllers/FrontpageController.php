<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Traits\CartTrait;
use App\Traits\UserTrait;

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

        $menu = ['Apple', 'Samsung', 'Oppo', 'Vsmart'];
        $menuList = $brands = [];
        foreach ($menu as $menu) {
            $brand = Brand::where('name', $menu)->pluck('id');
            array_push($brands, $brand->first());
            $menu = strtolower($menu);
            $products = Product::where('brand_id', $brand)->orderBy('id', 'desc')->take(18)->get();
            if (count($products) > 0) {
                $menuList[$menu] = $products;
            }
        }
        $others = Brand::whereNotIn('id', $brands)->get();
        $menuList['others'] = Product::whereIn('brand_id', $others->pluck('id'))->orderBy('id', 'desc')->take(12)->get();
        View::share(compact('menuList', 'others'));
    }

    public function home()
    {
        $new_arrival = Product::orderBy('id', 'desc')->take(10)->get();
        $products = Product::whereNotIn('id', $new_arrival->pluck('id'))->orderBy('id', 'desc')->paginate(12);

        $bs_orders = Order::where('status', Order::STT['completed'])->pluck('id');
        $bs_products = DB::table('order_details')
            ->select(DB::RAW('product_id, sum(quantity_ordered) AS total'))
            ->whereIn('order_id', $bs_orders)
            ->groupBy('product_id')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();
        $best_sellers = Product::find($bs_products->pluck('product_id'));
        return view('frontpage_def.pages.index', compact('products', 'best_sellers', 'new_arrival'));
    }

    public function brand($id)
    {
        $products = Product::where('brand_id', $id)->paginate(12);
        return view('frontpage_def.pages.product_list', compact('products'));
    }

    public function productDetails($id)
    {
        $product = Product::findOrFail($id);
        $relates = Product::where('brand_id', $product->brand_id)->where('id', '<>', $product->id)->take(10)->get();
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

    protected function getCartDetails()
    {
        $cart = session()->get('cart');
        if (!empty($cart)) {
            $products = Product::find($cart);
            $total = $products->sum('current_price');
            $quantity = session()->get('cart-quantity');
            if (!empty($quantity)){
                foreach ($quantity as $key => $value) {
                    foreach($products as $product) {
                        if ($product->id === $key) {
                            $total += $product->current_price * ($value - 1);
                        }
                    }
                }
            }
            return [
                'count' => count($cart),
                'total' => $total,
            ];
        } else {
            return [
                'count' => 0,
                'total' => 0,
            ];
        }
    }

    public function ajaxProduct(Request $request)
    {
        $product = Product::find($request->product);
        if ($product) {
            $html = view('frontpage_def.partials.modal_product_preview')->with('product', $product)->render();
            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        } else {
            return false;
        }
    }

    public function ajaxCart(Request $request)
    {
        $cart = session()->get('cart');
        $products = Product::with('images')->find($cart);
        $quantity = session()->get('cart-quantity');
        if ($quantity) {
            foreach ($quantity as $key => $value) {
                foreach($products as $product) {
                    if ($product->id === $key) {
                        $product->quantity = $value;
                    }
                }
            }
        }
        if ($products) {
            return response()->json([
                'success' => true,
                'data' => $products,
            ]);
        } else {
            return false;
        }
    }

    public function ajaxAddCart(Request $request)
    {
        $cart = session()->get('cart');
        if (empty($cart) || !in_array($request->product, $cart)) {
            session()->push('cart', $request->product);
        }
        $cart = session()->get('cart');
        if ($request->quantity || ( !empty($quantity = session()->get('cart-quantity')) 
        && array_key_exists($request->product, $quantity)
        && session()->get('cart-quantity')[$request->product] !== $request->quantity)) {
            session()->put('cart-quantity.' . $request->product, $request->quantity);
        }
        if (in_array($request->product, $cart)) {
            return response()->json([
                'success' => true,
                'data' => $this->getCartDetails(),
            ]);
        }
    }

    public function ajaxRemoveCart(Request $request)
    {
        $cart = session()->pull('cart', []);
        $key = array_search($request->product, $cart);
        if ($key !== false) {
            unset($cart[$key]);
        }
        session()->put('cart', $cart);
        $quantity = session()->pull('cart-quantity', []);
        if (array_key_exists($request->product, $quantity)) {
            unset($quantity[$request->product]);
        }
        session()->put('cart-quantity', $quantity);
        if (!in_array($request->product, $cart)) {
            return response()->json([
                'success' => true,
                'data' => $this->getCartDetails(),
            ]);
        }
    }

    public function ajaxEmptyCart()
    {
        $this->emptyCart();
        if (empty(session()->get('cart'))) {
            return response()->json(true);
        }
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
