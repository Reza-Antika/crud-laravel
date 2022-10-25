@extends('layouts.main')

@section('title', 'Belajar Laravel')

@section('page_title','Welcome')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Welcome</li>
@endsection 

@section('content')
<h1>Welcome</h1>
@endsection

@push('custom-script')
@endpush