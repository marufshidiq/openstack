@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Port Forwarding</div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{route('port.create.post')}}">
                        @csrf
                        <div class="form-group">
                            <label for="private_ip">Private IP</label>
                            <div class="input-group mb-3">
                                <input type="text" required class="form-control" id="private_ip" name="private_ip" aria-describedby="private_ip">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="private_port">Private Port</label>
                            <div class="input-group mb-3">
                                <input type="text" required class="form-control" id="private_port" name="private_port" aria-describedby="private_port">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{route('port.show')}}" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection