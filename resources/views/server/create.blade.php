@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Server</div>

                <div class="card-body">
                    <form method="POST" action="{{route('server.create.post')}}">
                        @csrf
                        <div class="form-group">
                            <label for="server_name">Server Name</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="server_name">{{$prefix}}</span>
                                </div>
                                <input type="text" required class="form-control" id="server_name" name="server_name" aria-describedby="server_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <select class="form-control" required name="image_id">
                                @foreach(\App\Image::orderBy('family', 'asc')->get() as $image)
                                <option value="{{$image->image_id}}">{{$image->family}} - {{$image->version}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{route('server.show')}}" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection