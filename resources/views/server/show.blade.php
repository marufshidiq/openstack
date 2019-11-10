@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Server List</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{route('server.create')}}">Create New Server</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Server Name</th>
                                    <th>Status</th>
                                    <th>IP Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servers as $server)
                                @php
                                    $server->retrieve();
                                @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$server->name}}</td>
                                    <td>{{$server->status}}</td>
                                    <td>
                                        @if($server->status == 'ACTIVE')
                                        <ul style="list-style-position: inside; padding-left: 0;">
                                        @foreach($server->listAddresses() as $addresses)
                                            @foreach($addresses as $address)
                                                <li>{{$address['addr']}}</li>
                                            @endforeach
                                        @endforeach
                                        </ul>
                                        @endif
                                    </td>
                                    <td>
                                        @if($server->status == 'ACTIVE')
                                        <a href="#" onClick="VNCWindow=window.open('{{formatVNCURL($server->getVncConsole()['url'])}}','VNCWindow','width='+screen.availWidth+',height='+screen.availHeight); return false;">VNC</a>
                                        @else
                                        -
                                        @endif
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