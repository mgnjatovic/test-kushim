<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller {
    /**
     * Display the Contacts homepage.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('contacts.index');
    }

    public function create() {
        return view('contacts.create');
    }
    /**
     * Display the Groups edit form for existing group.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $contact = Contact::find($id);
        return view('contacts.create')
            ->with('contact', $contact);
    }
}
