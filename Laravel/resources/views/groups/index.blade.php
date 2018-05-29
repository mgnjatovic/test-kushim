@extends('master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <groups-form :group-id="'{!! isset($group) ? $group->id : null !!}'"></groups-form>
                <groups></groups>
            </div>
        </div>
    </div>
@endsection