@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Port Forwarding List</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{route('home')}}">Home</a> |
                        <a href="{{route('port.create')}}">Create New Port Forwarding</a>
                        <table class="table" id="port_list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Public IP</th>
                                    <th>Port</th>
                                    <th>Private IP</th>
                                    <th>Port</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ports as $port)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{env('MIKROTIK_PUBLIC_IP')}}</td>
                                    <td>{{$port['dst-port']}}</td>
                                    <td>{{$port['to-addresses']}}</td>
                                    <td>{{$port['to-ports']}}</td>
                                    <td>
                                        <a href="{{route('port.delete', ['id'=>$port['.id']])}}" onclick="return confirm('Are you sure to delete this port?')">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection