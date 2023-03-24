@extends('admin.layouts')
@section('title' , 'Add Post')

@section('content')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Post</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" id="form-reset">
                @csrf
                <div class="card-body">
                    <div class="form-group" data-select2-id="65">
                        <label>Select User</label>
                        <select class="form-control select2bs4 select2-hidden-accessible" name="user_id" id="user_id" style="width: 100%;" data-select2-id="16" tabindex="-1" aria-hidden="true">

                            @foreach($users as $user)
                                <option value="{{$user->id}}"> {{$user->name}} </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Post content</label>
                        <textarea  class="form-control" name="text" id="text" rows="3" placeholder="Enter ..."></textarea>
                    </div>

                </div>


                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="button" onclick="addItem('/admin/posts/')" class="btn btn-primary">Submit</button>
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
            formData.append("user_id" , document.getElementById('user_id').value);
            formData.append("text" , document.getElementById('text').value);
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
