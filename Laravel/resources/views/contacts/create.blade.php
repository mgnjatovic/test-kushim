@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <contacts-form :contact-id="'{!! isset($contact) ? $contact->id : null !!}'"></contacts-form>
            </div>
        </div>
    </div>
@endsection