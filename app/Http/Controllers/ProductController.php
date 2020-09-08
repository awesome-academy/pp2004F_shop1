<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if ($user->can('viewAny', Product::class)) {
            $products = Product::with('brand:id,name')->orderBy('id', 'desc')->get();
            return view('admin_def.pages.product_index', compact('products'));
        } else {
            return view403();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        if ($user->can('create', Product::class)) {
            $brands = Brand::all();
            return view('admin_def.pages.product_create', compact('brands'));
        } else {
            return view403();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $request->validated();
        try {
            $request['slug'] = \Str::random(12);
            $request['properties'] = json_encode($request->properties);
            $product = Product::create($request->all());
            $product_flag = $product->save();
            $image_flag = true;
            if ($product_flag) {
                if(str_contains($request->image, ',')) {
                    $images = explode(',', $request->image);
                    foreach($images as $value) {
                        $image = new ProductImage();
                        $image->product_id = $product->id;
                        $image->image = $value;
                        $image_flag = $image->save();
                    }
                } else {
                    $img = new ProductImage();
                    $img->product_id = $product->id;
                    $img->image = $request->image;
                    $image_flag = $img->save();
                }
            }

            if ($product_flag && $image_flag) {
                return redirect()->route('admin.product.show', $product->id)
                    ->withMessage('OK');
            }
        } catch (Exception $e) {
            \Log::error("Error at " . __METHOD__ . ". Content: {$e->getMessage()}");
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \Auth::user();
        if ($user->can('view', Product::class)) {
            $product = Product::find($id);
            return view('admin_def.pages.product_show', compact('product'));
        } else {
            return view403();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \Auth::user();
        if ($user->can('update', Product::class)) {
            $product = Product::find($id);
            $brands = Brand::all();
            return view('admin_def.pages.product_edit', compact('product', 'brands'));
        } else {
            return view403();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $request->validated();
        
        try {
            $change_flag = false;
            $product_flag = $image_flag = true;
            $product = Product::find($id);
            $request['properties'] = json_encode($request->properties);
            
            $product->fill($request->all());
            if ($change_flag = $product->isDirty()) {
                $product_flag = $product->save();
            }

            foreach ($request->image as $key => $val) {
                $img = ProductImage::find($key);
                if ($img->image !== $val) {
                    $change_flag = true;
                    $image_flag = $img->fill(['image' => $val])->save();
                }
            }

            if ($change_flag && $product_flag && $image_flag) {
                return redirect()->route('admin.product.show', $product->id)
                ->withMessage('OK');
            }

            return redirect()->back()->withErrors('No Change has been made');
        } catch (\Exception $e) {
            \Log::error("Error at " . __METHOD__ . ". Content: {$e->getMessage()}");
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
