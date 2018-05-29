@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <contacts-form :contact-id="'{!! isset($contact) ? $contact->id : null !!}'" :group-id="'{!! isset($group) ? $group : null !!}'"></contacts-form>
                <contacts :group-id="'{!! isset($group) ? $group : null !!}'"></contacts>
            </div>
        </div>
    </div>
@endsection