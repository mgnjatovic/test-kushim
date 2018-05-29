<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Group;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller {
    public function index() {
        $contacts = Contact::latest()
            ->paginate(20);

        return ContactResource::collection($contacts);
    }

    /**
     * Fetch and return the contact.
     *
     * @param Contact $Contact
     * @return ContactResource
     */
    public function contacts(Group $group) {
        $id = $group->id;
        $contacts = Contact::whereHas('groups', function ($q) use ($id) {
            $q->where('group_id', '=', $id);
        })->get();

        return ContactResource::collection($contacts);
    }

    /**
     * Fetch and return the contact.
     *
     * @param Contact $Contact
     * @return ContactResource
     */
    public function show(Contact $contact) {
        return new ContactResource($contact);
    }

    /**
     * Validate and save a new contact to the database.
     *
     * @param Request $request
     * @return ContactResource
     */
    public function store(Request $request) {
        $contact = $this->validate($request, [
            'id' => '',
            'avatar' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'note' => 'required|string|max:255',
        ]);

        if($contact['id']=="") {
            $contact_edit = Contact::create($contact);
        } else {
            $contact_edit = Contact::find($contact['id']);
            $contact_edit->first_name = $contact['first_name'];
            $contact_edit->last_name = $contact['last_name'];
            $contact_edit->address = $contact['address'];
            $contact_edit->city = $contact['city'];
            $contact_edit->zip = $contact['zip'];
            $contact_edit->country = $contact['country'];
            $contact_edit->email = $contact['email'];
            $contact_edit->phone = $contact['phone'];
            $contact_edit->note = $contact['note'];
            $contact_edit->save();
        }

        //$contact = Contact::create($contact);

        $group = Group::find($request->group_id);
        if ($group)
            $contact->groups()->save($group);

        return new ContactResource($contact_edit);
    }

    public function destroy($id) {
        // delete
        Contact::destroy($id);
        // redirect
        return Redirect::to('/');
    }
    //
}
