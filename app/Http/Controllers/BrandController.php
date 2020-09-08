<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Repositories\Brand\BrandRepositoryInterface;

class BrandController extends Controller
{
    protected $brandRepo;

    public function __construct(BrandRepositoryInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if ($user->can('viewAny', Brand::class)) {
            $brands = $this->brandRepo->orderBy('id', 'desc')->get();
            return view('admin_def.pages.brand_index', compact('brands'));
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
        try {
            $user = \Auth::user();
            if ($user->can('create', Brand::class)) {
                $request['slug'] = \Str::random(16);
                $brand = $this->brandRepo->create($request->all());
                if ($brand->save()) {
                    return redirect()->back();
                }
            } else {
                return redirect()->back()
                    ->withErrors('Permission denied! You do not have permissions to do this action');
            }
        } catch (\Exception $e) {

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
        if ($user->can('view', Brand::class)) {
            $brand = $this->brandRepo->findOrFail($id);
            $products = Product::where('brand_id', $id)->orderBy('id', 'desc')->get();
            return view('admin_def.pages.brand_show', compact('brand', 'products'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = \Auth::user();
        if ($user->can('update', Brand::class)) {
            $brand = $this->brandRepo->find($id);
            $brand->fill($request->all());
            if ($brand->save()) {
                return redirect()->back();
            }
        } else {
            return redirect()->back()
                ->withErrors('Permission denied! You do not have permissions to do this action');
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
        $user = \Auth::user();
        if ($user->can('delete', Brand::class)) {
            $product = Product::where('brand_id', $id)->get();
            if (count($product) == 0) {
                $delete = $this->brandRepo->find($id)->delete();
                if ($delete) {
                    return redirect()->route('admin.brand.index');
                }
            }
            return redirect()->back();
        } else {
            return redirect()->back()
                ->withErrors('Permission denied! You do not have permissions to do this action');
        }
    }
}
