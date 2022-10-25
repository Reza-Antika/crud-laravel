@extends('layouts.main')

@section('title', 'Edit')

@section('page_title', 'Edit Page')

@section('breadcrumb')

<li class="breadcrumb-item"><a href="/">Home</a></li>
<li class="breadcrumb-item">Category</li>
<li class="breadcrumb-item active"><a>Edit</a></li>

@endsection

@section('content')

<div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Edit Page</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="/category/update/{{ $data->id }}" method="POST">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label>Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required value="{{ $data->name }}">
        </div>
        <div class="form-group">
          <label>Quantity</label>
          <textarea class="form-control" rows="3" id="quantity" name="quantity" placeholder="Enter quantity">{{ $data->quantity }}</textarea>
        </div>
            <div class="form-group">
                <select class="form-control" name="status_active" id="" class="form-control" >
                  <option value="ACTIVE" {{ $data->status_active == 'ACTIVE' ? 'selected' : ''}}>Active</option>
                  <option value="NONACTIVE" {{ $data->status_active == 'NONACTIVE' ? 'selected' : ''}}>Nonactive</option>
                </select>
            </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>

@endsection