<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Group;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;

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

        try {
            $contact = $this->validate($request, [
                'id' => '',
                'avatar' => '',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'zip' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'required|string|max:255',
                'note' => 'required|string|max:255',
                'groups' => ''
            ]);

            if ($contact['id'] == "") {
                $contact_edit = Contact::create($contact);
            } else {
                $this->editContact($request, $contact);
            }
            //return new ContactResource($contact_edit);
            return response()->json([
                'status' => 'success',
                'success' => 'Contact saved successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id) {
        // delete
        Contact::destroy($id);
        // redirect
        return Redirect::to('/');
    }

    /**
     * @param $contact
     * @param $contactgroups
     * @return array
     */
    private function getContactGroups($contact) {
        foreach ($contact['groups'] as $id => $name) {
            $contactgroups[] = ['contact_id' => $contact['id'], 'group_id' => $name['id']];
        }
        return $contactgroups;
    }

    /**
     * @param Request $request
     * @param $contact
     */
    private function editContact(Request $request, $contact) {
        $contact_edit = Contact::find($contact['id']);
        $contactgroups = $this->getContactGroups($contact);
        if (isset($contact['avatar']) && $contact['avatar'] != $contact_edit->avatar) {
            $contact_edit->avatar = $this->storeImage($request);
        }
        $contact_edit->first_name = $contact['first_name'];
        $contact_edit->last_name = $contact['last_name'];
        $contact_edit->address = $contact['address'];
        $contact_edit->city = $contact['city'];
        $contact_edit->zip = $contact['zip'];
        $contact_edit->country = $contact['country'];
        $contact_edit->email = $contact['email'];
        $contact_edit->phone = $contact['phone'];
        $contact_edit->note = $contact['note'];
        $contact_edit->groups()->sync($contactgroups);
        $contact_edit->save();
    }

    private function storeImage(Request $request) {
        try {
            if ($request->get('avatar')) {
                $id = $request->get('id');
                $email = $request->get('email');
                $name = $id . preg_replace('/[^a-zA-Z0-9]/', '', $email);
                \Image::make($request->get('avatar'))->save(public_path('images/') . "{$name}.jpg");
            }
            return "/images/{$name}.jpg";
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $e->errors(),
            ], 422);
        }
    }
}
