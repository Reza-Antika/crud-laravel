@extends('layouts.main')

@section('title'.'Profile')
@section('page_title','Profile')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="/"> Home </a>
    </li>
    <li class="breadcrumb-item active">
        <a> Profile </a>
    </li>

@endsection

@section('content')
{{-- <div class="modal fade" id="modalProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content"> --}}
        <div class="content">
            <form action="#" class="form-profile">
                @csrf
                {{-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Profile Anda</h5>
                </div> --}}
                <div class="modal-body">
                <div class="form-group" >
                    <label >Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" disabled>
                    <input type="hidden" name="id"  id="updateId">
                </div>
                <div class="form-group" >
                    <label >Email</label>
                    <input name="email" class="form-control"  rows="3" placeholder="Enter Email" disabled>
                </div>
                </div>
                <div class="modal-footer">
                <div class="row">
                        <div class="col-md-auto">
                        <button type="button" class="btn btn-change btn-primary" data-toggle="modal" data-target="#modalChange">Change Password</button>
                        </div>
                        <div class="col">
                        <button type="submit" class="btn btn-update btn-primary" data-toggle="modal" data-target="#modalUpdate">Update</button>
                        </div>
                </div> 
                </div>
            </form>
        </div>
        
      {{-- </div>
    </div>
</div> --}}

<!-- Modal Update-->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="#" class="form-update">
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
                {{-- <input type="hidden" name="id"> --}}
            </div>
            <div class="form-group" >
                <label >Email</label>
                <input name="email" class="form-control"  rows="3" placeholder="Enter Email">
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

<!-- Modal Change-->
<div class="modal fade" id="modalChange" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form class="form-change" method="POST">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group" >
                <label >Old Password</label>
                <input type="password" name="old_password" class="form-control" placeholder="Enter Old Password" >
                
            </div>
            <div class="form-group" >
                <label >New Password</label>
                <input type="password" name="new_password" class="form-control"  rows="3" placeholder="Enter New Password">
            </div>
            <div class="form-group" >
                <label >Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control"  rows="3" placeholder="Enter Confirm Password">
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
     })

     function loadData(){
        $.ajax({
                url: "/profile/getData",
                type: "GET",
                data: {}
            }).done(function(result) {
                    var form = $('.form-profile')

                    form.find("input[name=id]").val(result.id)
                    form.find("input[name=name]").val(result.name)
                    form.find("input[name=email]").val(result.email)

            }).fail(function(xhr, error) {
                console.log('xhr', xhr.status)
                console.log('error', error)

            })
                  
     }

     $(document).on('click', '.btn-update', function(e){
    e.preventDefault();

    $.ajax({
        url :"/profile/getData",
        type: "GET",
        data: {
            id:$(this).data('id')
        }

        }).done(function(result) {
            var form = $('.form-update')

            form.find("input[name=id]").val(result.id)
            form.find("input[name=name]").val(result.name)
            form.find("input[name=email]").val(result.email)

        }).fail(function(xhr, error) {
            console.log('xhr', xhr.status)
            console.log('error', error)

        })
})

     $(document).on('submit', '.form-update', function(e){
    e.preventDefault()

    var form = $(this)
    var inputToken = form.find("input[name=_token]")

    $.ajax({
        url:"/profile/updateData/"+form.find("input[name=id]").val(),
        type:"POST",
        data:{
            _token: inputToken.val(),
            name: form.find("input[name=name]").val(),
            email:form.find("input[name=email]").val(),
        }
    }).done(function(result){
        inputToken.val(result.newToken)
        

        if(result.status){
            $('#modalUpdate').modal('hide')
            alert(result.message)
            loadData()
        }else{

        }
    }).fail(function(xhr, error){
        console.log('xhr', xhr.status)
        console.log('error', error)
    })
})

        $(document).on('submit', '.form-change', function(e) {
            e.preventDefault()

            var thisId = $('#updateId').val();
            var form = $(this)
            var inputToken = form.find("input[name=_token]")
            

            $.ajax({
                url: "/profile/updatePassword/"+thisId,
                type: "POST",
                data: {
                    _token: inputToken.val(),
                    
                    old_password: form.find("input[name=old_password]").val(),
                    new_password: form.find("input[name=new_password]").val(),
                    confirm_password: form.find("input[name=confirm_password]").val(),

                }

            }).done(function(result) {
                inputToken.val(result.newToken)

                if (result.status) {
                    $('#modalChange').modal('hide')
                    alert(result.message)
                    window.location.href = '/logout'

                } else {
                    alert(result.message)

                }

            }).fail(function(xhr, error) {

            })
        })
 
</script>
@endpush