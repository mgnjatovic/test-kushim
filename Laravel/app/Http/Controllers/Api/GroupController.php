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
        $group = $this->validateGroup($request);
        if($group['id']=="") {
            $group_edit = Group::create($group);
        } else {
            $group_edit = $this->editGroup($group);
        }
        return new GroupResource($group_edit);
    }

    public function destroy($id) {
        Group::destroy($id);
        return Redirect::to('/');
    }

    private function validateGroup(Request $request) {
        $group = $this->validate($request, [
            'id' => '',
            'name' => 'required|min:3|max:50'
        ]);
        return $group;
    }

    private function editGroup($group) {
        $group_edit = group::find($group['id']);
        $group_edit->name = $group['name'];
        $group_edit->save();
        return $group_edit;
    }
}
