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
    }

    public function index() {
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
