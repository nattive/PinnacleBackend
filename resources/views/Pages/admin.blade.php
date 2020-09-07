@extends('layouts\container')

@section('body')
<site-component :user='{{Auth::user()}}'></site-component>
@endsection
