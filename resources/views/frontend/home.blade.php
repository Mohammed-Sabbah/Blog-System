<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>blog_system</title>
    <link rel="stylesheet" href="{{asset('cms/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('cms/assets/fonts/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('cms/assets/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap_style.css')}}">
    <link rel="stylesheet" href="{{asset('cms/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href=" {{asset('cms/plugins/toastr/toastr.min.css')}} ">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('cms/dist/css/adminlte.min.css')}}">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md" style="background: var(--bs-link-hover-color);color: var(--bs-gray-200);">
        <div class="container-fluid">
            <div class="container" style="display: flex;justify-content: center;">
                <img class="img-circle img-bordered-sm" style="border-color:#35f44c" src="{{Storage::url('users/' . Auth::user()->cover)}}" alt="" width="50px" height="50px">
                <h6 class="ml-3 mb-0">{{Auth::user()->name}}</h6>
                <div class="collapse navbar-collapse" id="navcol-1">

                </div>

                {{-- href="{{route('user.logout')}}" --}}
                <a  class="btn  btn-success mr-4" data-toggle="modal" data-target="#modal-lg" style="float: right;">Add Post</a>
                <a href="{{route('user.logout')}}" class="btn  btn-warning" style="float: right;">Logout</a>

            </div>
            <button data-bs-target="#navcol-1" data-bs-toggle="collapse" class="navbar-toggler" style="color: var(--bs-gray-100);">
                <span class="visually-hidden">
                    Toggle navigation
                </span>
                <span class="navbar-toggler-icon" style="background: var(--bs-navbar-disabled-color);"></span>
            </button>
        </div>
    </nav>
    <section>
        @foreach ($posts as $post )
        <div class="container">
            <div class="row" style="padding-top: 30px; width:80% ; margin:auto; background-color:rgba(10, 88, 202 , 0.2);">
                <div class="post">
                    <div class="user-block">
                      <img class="img-circle img-bordered-sm"  src="{{Storage::url('users/'.$post->user->cover)}}" alt="user image">
                      <span class="username">
                        <a href="#">{{$post->user->name}}</a>
                      </span>
                      <span class="description">{{$post->created_at}}</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                      {{$post->text}}
                    </p>

                    <p>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Likes ({{count($post->likes)}})</a>
                        <a class="link-black text-sm ml-3" style="cursor: pointer" onclick="toggle({{$post->id}})">
                            <i class="far fa-comments mr-1"></i> Comments ({{count($post->comments)}})
                        </a>
                    </p>
                    <form action="{{route('make_comment' , $post->id)}}" method="post" style="display: flex">
                        @csrf
                        <input class="form-control form-control-sm col-md-11" name="text" type="text" placeholder="Type a comment" required>
                        <button type="submit" class="btn  btn-primary btn-xs col-md-1"><i class="fa fa-paper-plane"></i></button>
                    </form>
                  </div>

            {{-- -----------------------------------comments -------------------------------------------- --}}
                  <div id="content-{{$post->id}}" style="margin: auto; display:none;">

                    @foreach ($post->comments as $comment )

                    <div class="container">
                        <div class="row mb-2" >
                            <div class="col-10" style="margin: auto">
                                <div class="card card-white post" style="padding: 10px">
                                    <div class="post-heading">
                                        <div class="float-left image">
                                            <img src="{{Storage::url('users/'.$comment->user->cover)}}" width="40px" height="40px" class="img-circle avatar" alt="user profile image">
                                        </div>
                                        <div class="float-left meta">
                                            <div class="title h5">
                                                <a href="#" class="ml-2" style="font-size:16px"><b>{{$comment->user->name}} </b></a>

                                            </div>
                                            <p class="text-muted time" style="font-size:16px">{{$comment->created_at}}</p>
                                        </div>
                                    </div>
                                    <div class="post-description" style="padding: 10px">
                                        <p>{{$comment->text}} </p>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    @endforeach

                  </div>




                    </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach









    </section>


    <div class="modal fade show" id="modal-lg" style=" padding-right: 17px;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Post</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" id="form-reset">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Post content</label>
                                    <textarea  class="form-control" name="text" id="text" rows="3" placeholder="Enter ..."></textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" onclick="addItem('/make_post/')" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->



                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>














    <script src="{{asset('cms/assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src=" {{ asset('js/axios.js') }} "></script>
    <script src="{{asset('cms/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('js/bootstrap_js.js')}}"></script>
    <script src="{{asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- AdminLTE App -->
    <script src="{{asset('cms/dist/js/adminlte.min.js')}}"></script>

    <script>

        function toggle(id){
            var content = document.getElementById("content-"+id);


            if (content.style.display === "none") {
                content.style.display = "block";
            } else {
                content.style.display = "none";
            }



        }
    </script>


<script>
    function addItem(url){
        var formData = new FormData();
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



</body>

</html>
