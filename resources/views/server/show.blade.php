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
                        <table class="table" id="server_list">
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
                                try{
                                    $server->retrieve();
                                    if($server->status == "DELETED"){
                                        continue;
                                    }
                                }
                                catch (Exception $e) {
                                    continue;
                                }
                                @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$server->name}}</td>
                                    @if($server->status == 'BUILD')
                                    <td colspan="3">
                                        @else
                                    <td>
                                        @endif
                                        @if($server->status == 'BUILD')
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                                Build
                                            </div>
                                        </div>
                                        @else
                                        {{$server->status}}
                                        @endif
                                    </td>
                                    @if($server->status != 'BUILD')
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
                                        <a href="#" onClick="VNCWindow=window.open('{{route('server.vnc', ['id'=>$server->id])}}','VNCWindow','width='+screen.availWidth+',height='+screen.availHeight); return false;">VNC</a>
                                        |
                                        <a href="{{route('server.delete', ['id'=>$server->id])}}" onclick="return confirm('Are you sure to delete this server?')">Delete</a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    @endif
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

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    var build = 0;

    $(document).ready(function() {
        var refresh = setInterval(function() {
            if (build != 0) {
                location.reload();
            }
        }, 10000);
    });

    $("#server_list tr td:nth-child(3)").each(function() {
        var status = this.innerText.trim();
        if (status === "Build") {
            build += 1;
        }
    });
</script>
@endsection