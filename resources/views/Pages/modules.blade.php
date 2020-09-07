@extends('layouts\container')

@section('body')
<modules-component :course='{{ $course }}'></modules-component>
@endsection
