<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Ajax Crud</title>
</head>

<body class="bg-danger">
    <div class="container">
            <!-- Button trigger modal -->
        <button type="button" class="btn bg-outline-dark text-light fs-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">
           <b>Add Data<hr></b>
        </button>
        <button type="button" class="btn bg-outline-dark text-light fs-bold d-none btn-open" data-bs-toggle="modal" data-bs-target="#exampleModal2">
            <b>Update Data<hr></b>
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                    <h5 class="modal-title text-light" id="exampleModalLabel2">Update Client Data</h5>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form  id="postData">

                    </form>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Client Form</h5>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form  id="post">
                        <div class="modal-body bg-dark">
                            <div class="mb-3">
                            <label for="" class="form-label text-white ">Name</label>
                            <input type="text"
                                class="form-control" name="name" id="" aria-describedby="helpId" placeholder="Enter Your Name...">
                            </div>
                            <div class="mb-3">
                            <label for="" class="form-label text-white ">Address</label>
                            <input type="text"
                                class="form-control" name="address" id="" aria-describedby="helpId" placeholder="Enter Your Address...">
                            </div>
                            <div class="mb-3">
                            <label for="" class="form-label text-white ">Number</label>
                            <input type="text"
                                class="form-control" name="number" id="" aria-describedby="helpId" placeholder="Enter Your Number...">
                            </div>
                        </div>
                    <div class="modal-footer bg-dark">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="row">
            <h1 class="text-center text-light">Show Your Data</h1>
            <table id="mytable" class="table table-danger table-striped table-hover table-bordered table-sm table-responsive-sm">
                <thead>
                    <tr class="text-center">
                        <th scope="col">SI</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Number</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody id="data">
                    
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function()
        {
            $('#mytable').get();
            getClientData();

            $('#post').on('submit',function(e)
            {
                e.preventDefault();

                jQuery.ajax({
                        url:"{{url('/save')}}",
                        method:'post',
                        data:jQuery('#post').serialize(),
                        success:function(response){
                            jQuery('#post')[0].reset();
                            $('.btn-close').trigger('click');
                            getClientData();
                        }
                })
            })

        });

        function getClientData () 
        {
            $.ajax({
                        url:"{{url('/get_data')}}",
                        method:'get',
                        success:function(data)
                        {
                            $('#data').html(data);
                        }
                })
        };

        

        $(document).on('click','.edit', function()
        {
            var data = $(this).attr('data');
            jQuery.ajax({
                        url:"{{url('/edit_data')}}",
                        method:'get',
                        data:{id:data},
                        success:function(data){
                            $('#postData').html(data);
                            $('.btn-open').trigger('click');
                        }
                })
                    $('#postData').on('submit',function(e)
                    {
                        e.preventDefault();
                        var id = $('#id').val();
                        const fob = new FormData(this);

                         
                        jQuery.ajax({
                                url:"/update/"+id,
                                data:fob,
                                method:'post',
                                dataType: 'json',
                                contentType: false,
                                cache: false,
                                processData: false,
                                success:function(data){
                                    $('.btn-close').trigger('click');
                                    getClientData();
                                }
                        })
                    });
        });
        

        $(document).on('click','.delete',function(){
            var data = $(this).attr('data');
            jQuery.ajax({
                url:"/delete/"+data,
                method:'post',
                data:{id:data},
                success:function(data){
                    getClientData();
                }
            })
        });
            
            
        
    </script>
</body>
</html>