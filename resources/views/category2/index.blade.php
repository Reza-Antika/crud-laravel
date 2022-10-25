@extends('layouts.main')

@section('title', 'Category 2')

@section('page_title', 'Category 2')

@section('breadcrumb')

<li class="breadcrumb-item"><a href="/">Home</a></li>
<li class="breadcrumb-item active"><a>Category</a></li>

@endsection

@section('content') 
    <div class="row">

        <div class="col-md-10">
        </div>
        <div class="col-md-2">
            <button type="button"  class="btn btn-block btn-success" data-toggle="modal" data-target="#modalCreate">
                Create
              </button>
        </div>

        <div class="col-md-12">
            <div class="card-header">
                <h3 class="card-title">List Data</h3>
            </div>
        
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="dataTable" class="table table-bordered">
            
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Status_active</th>
                                <th>Craeted_At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
            
                </div>
            </div>
           
        </div>
    </div>

    <!-- Modal Create-->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="#" class="form-create">
            @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Create Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group" >
            <label >Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name" required >
            
          </div>
          <div class="form-group" >
            <label >Quantity</label>
            <textarea name="quantity" class="form-control"  rows="3" placeholder="Enter quantity"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
      </div>
    </div>
</div>

<!-- Modal Edit-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="#" class="form-edit">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group" >
                <label >Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" >
                <input type="hidden" name="id">
            </div>
            <div class="form-group" >
                <label >quantity</label>
                <textarea name="quantity" class="form-control"  rows="3" placeholder="Enter Quantity"></textarea>
            </div>
            <div class="form-group" id="status_active"  >
                <label >Status</label>
            <select class="form-control" name="status_active">
                <option value="ACTIVE" >active</option>
                <option value="NONACTIVE" >non active</option>
                
            </select>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
       </form>
      </div>
    </div>
</div>
    
@endsection

@push('custom-script')
<script>
    $(function(){
       loadData()
    });

    function loadData(){
        $.ajax({
        url:"category2/getData",
        type:"GET",
        data:{}
    }).done(function(result){
        $('#dataTable').DataTable({
            "paging":true,
            "searching":true,
            "ordering": true,
            "responsive":true,
            "destroy": true,
            "data":result.data, 
            "columns":[
                {"data":"no"},
                {"data":"name"},
                {"data":"quantity"},
                {"data":"status_active"},
                {"data":"created_at"},
                {"data":"id"},
            ],
            "columnDefs":[
                {
                        "targets": 5,
                        "data" : "id",
                        "render" : function(data,type,row){
                            return '<div class="btn-group">'+
                '<button type="button" class="btn btn-default">Action</button>'+
                '<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">'+
                  '<span class="sr-only">Toggle Dropdown</span>'+
                '</button>'+
                '<div class="dropdown-menu" role="menu">'+
                  '<a class="dropdown-item btn-edit" data-id="'+row.id+'">Edit</a>'+
                  '<input type=submit class="dropdown-item btn-delete" data-id="'+row.id+'"  value="delete">'+
                  '<input type="submit" class="dropdown-item btn-update-status" data-id="' +
                                    row.id + '" id="form-update-status" value="' + (row
                                        .status_active ==
                                        "ACTIVE" ? "Deactive" : "Activate") + '" "href="#">' +
                                    '</div>' +
                                    '</div>';
                '</div>'+

              '</div>';
                        }

                    }
            ],
        });
    }).fail(function(xhr, error){
        console.log('xhr', xhr.status)
        console.log('error', error)
    })
    }


    $(document).on('submit', '.form-create', function(e){

        e.preventDefault();
        var form = $(this)
        var inputToken = form.find("input[name=_token]")
        $.ajax({
            url : "/category2/createData",
            type : "POST",
            data : {
                _token : inputToken.val(),
                // find= fungsinya, input=text, name=name
                name : form.find("input[name=name]").val(),
                quantity : form.find("textarea[name=quantity]").val()
            }
        }).done(function(result){

            inputToken.val (result.newToken)
            if(result.status){
                $('#modalCreate').modal('hide')
                alert(result.message)
                loadData()
            }else{
                alert(result.message)
            }
        }).fail(function(xhr, error){
                
            })
        })

        $(document).on('click', '.btn-edit', function(e){
        e.preventDefault();

        $.ajax({
            url :"/category2/getData",
            type: "GET",
            data: {
                id:$(this).data('id')
            }

        }).done(function(result){
            if(result.data){
                var form = $('.form-edit')
                var data= result.data

                form.find("input[name=id]").val(data.id),
                form.find("input[name=name]").val(data.name),
                form.find("textarea[name=quantity]").val(data.quantity),
                form.find("select[name=status_active]").val(data.status_active)

                $('#modalEdit').modal('show');
            } else{
                alert("data not found")
            }
        }).fail(function(xhr,error){
            console.log('xhr',xhr.status)
            console.log('error',error)
        })
    })

    $(document).on('submit', '.form-edit', function(e){
        e.preventDefault()

        var form = $(this)
        var inputToken = form.find("input[name=_token]")

        $.ajax({
            url:"/category2/updateData/"+form.find("input[name=id]").val(),
            type:"POST",
            data:{
                _token: inputToken.val(),
                name: form.find("input[name=name]").val(),
                quantity:form.find("textarea[name=quantity]").val(),
                status_active:form.find("select[name=status_active]").val(),
            }
        }).done(function(result){
            inputToken.val(result.newToken)
            

            if(result.status){
                $('#modalEdit').modal('hide')
                loadData()
            }else{
                alert(result.message)
                }
            }).fail(function(xhr, error) {
                console.log('xhr', xhr.status)
                console.log('error', error)
            })
    })

    $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault()

            if(confirm('Are you sure to delete data ?')) {
                var inputToken = $("input[name=_token]")

                $.ajax({
                    url: "/category2/deleteData/"+$(this).data('id'),
                    type: "POST",
                    data: {
                        _token: inputToken.val()
                    }
                }).done(function(result) {

                    inputToken.val(result.newToken)
                    if (result.status) {
                        loadData()
                    } else {
                        alert(result.message)
                    }

                }).fail(function(xhr, error) {
                    console.log('xhr', xhr.status)
                    console.log('error', error)
                })
            }
            
            
        })

        $(document).on('click', '.btn-update-status', function(e) {

// untuk mencek tombol action status_active: 
// console.log('check', 'kepanggil')

        var inputToken = $("input[name=_token]")
        e.preventDefault();

        $.ajax({
            url: "/category2/updateStatus/" + $(this).data('id'),
            type: "POST",
            data: {
                _token: inputToken.val(),

            }
        }).done(function(result) {

            inputToken.val(result.newToken)

            if (result.status) {
                alert(result.message)
                loadData()
            } else {
                alert(result.message)
            }
        }).fail(function(xhr, error) {
            console.log('xhr', xhr.status)
            console.log('error', error)
        })
        })
</script>
    
@endpush