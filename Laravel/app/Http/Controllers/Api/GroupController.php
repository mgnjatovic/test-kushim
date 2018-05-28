<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Group;
use App\Http\Resources\GroupResource;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller {
    public function index() {
        $groups = Group::latest()
            ->paginate(20);

        return GroupResource::collection($groups);
    }

    /**
     * Fetch and return the Group.
     *
     * @param Group $group
     * @return GroupResource
     */
    public function show(Group $group) {
        return new GroupResource($group);
    }

    /**
     * Validate and save a new Group to the database.
     *
     * @param Request $request
     * @return GroupResource
     */
    public function store(Request $request) {
        $group = $this->validate($request, [
            'id' => '',
            'name' => 'required|min:3|max:50'
        ]);

        if($group['id']=="") {
            $group = Group::create($group);
        } else {
            $group_edit = group::find($group['id']);
            $group_edit->name = $group['name'];
            $group_edit->save();
        }

        return Redirect::to('/');
    }

    public function destroy($id) {
        // delete
        Group::destroy($id);
        // redirect
        return Redirect::to('/');
    }
}
