<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function __construct()
    {
        $this->openstack = new \OpenStack\OpenStack(config('openstack.default'));
        $this->compute = $this->openstack->computeV2(['region' => env('OPENSTACK_REGION')]);
    }

    public function show()
    {
        $servers = $this->compute->listServers(true);
        return view('server.show', compact('servers'));
    }

    public function vnc($id)
    {
        $server = $this->compute->getServer(['id' => $id]);
        $consoleURL = $server->getVncConsole()['url'];
        return view('server.vnc', compact('consoleURL'));
    }
}
