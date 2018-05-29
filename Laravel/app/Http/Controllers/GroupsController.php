<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller {
    /**
     * Display the Groups homepage.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('groups.index');
    }

    public function show($id) {
        return view('contacts.index')
            ->with('group', $id);
    }

    /**
     * Display the Groups edit form for existing group.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $group = Group::find($id);
        return view('groups.create')
            ->with('group', $group);
    }
}
