@extends('layouts\container')

@section('body')
<testimonials-component :user="{{auth('admin')->user()}}"></testimonials-component>
@endsection

