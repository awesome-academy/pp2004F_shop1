<?php

namespace App\Http\Controllers;

use App\Repositories\Contact\ContactRepositoryInterface;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Routing\Route;

class ContactController extends Controller
{
    protected $contactRepository;
    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
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
        \View::share(compact('menuList', 'others'));
    }

    public function index() {
        //return view('frontpage_def.pages.contact');
        $contacts=Contact::all();
        return view('admin_def.pages.contact_index', compact('contacts'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $contact = $this->contactRepository;
        $contact->name = $request->get('name');
        $contact->email = $request->get('email');
        $contact->subject = $request->get('subject');
        $contact->message = $request->get('message');
        $contact->save();
        return redirect()->route('admin.contact.index');
    }

    public function edit()
    {
        //
    }

    public function save(Request $request)
    {
        $contact = new Contact();
        $contact->name = $request->get('name');
        $contact->email = $request->get('email');
        $contact->subject = $request->get('subject');
        $contact->message = $request->get('message');

        if($contact->save()) {
            return redirect(Route('contact_index'))->with('status', 'Profile updated!');
        }
    }

    public function contact()
    {
        $contacts = Contact::all();
        return view('admin_def.pages.contact_index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::find($id);
        return view('admin_def.pages.contact_show', compact('contact'));
    }
}
