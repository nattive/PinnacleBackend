@extends('layouts\container')

@section('body')
<all-course :user='{{Auth::user()}}'></all-course>
@endsection
