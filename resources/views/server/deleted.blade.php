@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Server Delete</div>

                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        Your server is being deleted, please wait until this page redirect to <strong>server list</strong> automatically.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    var still_exist = {{$still_exist}};

    $(document).ready(function() {
        if(!still_exist){
            window.location.href = '{{route('server.show')}}';
        }
        var refresh = setInterval(function() {
            if (still_exist) {
                location.reload();
            }
            else {
                window.location.href = '{{route('server.show')}}';
            }
        }, 5000);
    });
</script>
@endsection