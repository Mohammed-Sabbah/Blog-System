@extends('admin.layouts')
@section('title' , 'Add User')

@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" id="form-reset">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">User Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter User Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Select Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="cover" id="cover">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" onclick="addItem('/admin/users/')" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.card -->



    </div>
@endsection

@section('script')
    <script>
        function addItem(url){
            var formData = new FormData();
            formData.append("name" , document.getElementById('name').value);
            formData.append("password" , document.getElementById('password').value);

            if (document.getElementById('cover').files[0] != undefined){
                formData.append("cover" , document.getElementById('cover').files[0]);
            }

            axios.post(url , formData)
                .then(function (response){
                    document.getElementById('form-reset').reset();
                    toastr.success(response.data.message);

            }).catch(function (error){
                    toastr.error(error.response.data.message);
            });
        }
    </script>
@endsection()
