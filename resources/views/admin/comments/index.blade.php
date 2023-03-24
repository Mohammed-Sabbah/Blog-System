@extends('admin.layouts')
@section('title' , 'Comments')

@section('content')

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title ">Comments Table</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Content</th>
                        <th>Commenter</th>
                        <th>Poster</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($data as $comment)
                        <tr>
                            <td> {{$comment->id}} </td>
                            <td> {{$comment->text }} </td>
                            <td>  {{ $comment->user->name }}  </td>
                            <td>  {{ $comment->post->user->name }} </td>
                            <td> {{$comment->created_at}} </td>
                            <td> {{$comment->updated_at}} </td>
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
