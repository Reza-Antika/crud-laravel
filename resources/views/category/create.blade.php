@extends('layouts.main')

@section('title', 'Category')

@section('page_title', 'Create Category')

@section('breadcrumb')

    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item"><a href="/category">Category</a></li>
    <li class="breadcrumb-item active">Create</a></li>

@endsection

@section('content')

<div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Form Create</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="/category/store" method="POST">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label>Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
        </div>
        <div class="form-group">
          <label>Supplier</label>
          <input class="form-control" rows="3" id="supplier" name="supplier" placeholder="Enter supplier">
        </div>
        <div class="form-group">
          <label>Quantity</label>
          <input class="form-control" rows="3" id="quantity" name="quantity" placeholder="Enter quantity">
        </div>
        {{-- <div class="form-group">
          <label>Entery Date</label>
          <input class="form-control" rows="3" id="quantity" name="quantity" placeholder="Enter entery date">
        </div> --}}
        
        <div class="form-group">
          <label>Expired</label>
          <input class="form-control" rows="3" id="expired" name="expired" placeholder="Enter expired">
        </div>
      </div>
       
      
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>

@endsection