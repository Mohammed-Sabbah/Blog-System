@extends('admin.layouts')
@section('title' , 'Posts')

@section('content')

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mt-2">Posts Table</h3>
                <a href="{{route('posts.create')}}" class="btn bg-gradient-success" style="float: right">Add Post</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Content</th>
                        <th>Comments</th>
                        <th>Likes</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($data as $post)
                        <tr>
                            <td> {{$post->id}} </td>
                            <td> {{$post->text }} </td>
                            <td> <span class="badge-success " style="padding: 2px 5px; border-radius:15px ;"> {{ count($post->comments) }}  </span> </td>
                            <td> <span class="badge-success" style="padding: 2px 5px; border-radius:15px ;"> {{ count($post->likes) }}  </span></td>
                            <td> {{$post->created_at}} </td>
                            <td> {{$post->updated_at}} </td>
                            <td>
                                <div class="btn-group">

                                    <a href=" {{ route('posts.edit' ,$post->id ) }} " class="btn btn-info"><i class="fas fa-edit"></i></a>

                                    <form method="post" >
                                        @csrf
                                        <button type="button" class="btn btn-danger" onclick="deleteItem('/admin/posts/' , this , {{$post->id}})"><i class="fas fa-trash"></i></button>
                                    </form>

                                </div>
                            </td>
                        </tr>>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
            </div>
        </div>
        <!-- /.card -->
    </div>

@endsection
@section('script')
    <script>
        function deleteItem(url , ref , id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(url+id)
                        .then(function (response){
                            showMessag(response.data )
                            ref.closest('tr').remove();
                        }).catch(function (error){
                        showMessag(error.response.data)
                    })
                }
            })
        }
        function showMessag(data){
            Swal.fire({
                icon: data.icon,
                title: data.message,
                showConfirmButton: false,
                timer: 1000
            })
        }

    </script>

@endsection
