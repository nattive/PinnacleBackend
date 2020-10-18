@extends('layouts\container')

@section('body')
<add-blog :user="{{auth('admin')->user()}}"></add-blog>
@endsection

