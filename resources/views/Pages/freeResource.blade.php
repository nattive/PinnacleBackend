@extends('layouts\container')

@section('body')
<free-resource :user="{{Auth::user()}}"></free-resource>
@endsection
