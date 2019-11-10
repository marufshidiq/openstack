<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ServerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->openstack = new \OpenStack\OpenStack(config('openstack.default'));
        $this->compute = $this->openstack->computeV2(['region' => env('OPENSTACK_REGION')]);
    }

    public function show()
    {
        $servers = $this->compute->listServers(false, [
            'name' => '^'.$this->getPrefix()."_"
        ]);

        return view('server.show', compact('servers'));
    }

    public function create()
    {
        $prefix = $this->getPrefix()."_";
        return view('server.create', compact('prefix'));
    }

    public function createServer(Request $request)
    {
        $user = Auth::user();
        $options = [
            'name'     => $this->formatServerName($request->server_name),
            'imageId'  => $request->image_id,
            'flavorId' => env('OPENSTACK_FLAVOR_DEFAULT'),

            'networks'  => [
                ['uuid' => env('OPENSTACK_NETWORK_DEFAULT')]
            ],

            'metadata' => [
                'user' => $user->id_number,
                'scope' => $user->scope,
                'year' => $user->year
            ]
        ];

        // Create the server
        $server = $this->compute->createServer($options);
        return redirect()->route('server.show');
    }

    public function delete($id)
    {
        $server = $this->compute->getServer(['id' => $id]);
        $server->delete();
        return redirect()->route('server.deleted', ['id' => $id]);
    }

    public function deleted($id)
    {
        $still_exist = $this->isServerExist($id);
        if(!$still_exist){
            return redirect()->route('server.show');
        }
        return view('server.deleted', compact('still_exist'));
    }

    public function vnc($id)
    {
        $exist = $this->isServerExist($id);
        if(!$exist){
            return redirect()->route('home');
        }
        $server = $this->compute->getServer(['id' => $id]);
        $server->retrieve();

        if (!preg_match('/^'.$this->getPrefix().'_/', $server->name))
        {
            return redirect()->route('home');
        }

        $consoleURL = $server->getVncConsole()['url'];
        $consoleURL = formatVNCURL($consoleURL);
        return view('server.vnc', compact('consoleURL'));
    }

    public function getPrefix()
    {
        return substr(Auth::user()->scope, 0, 1).Auth::user()->id_number;
    }

    public function formatServerName($name)
    {
        $name = preg_replace("/[^A-Za-z0-9]/", '', $name);
        $name = $this->getPrefix()."_".$name;
        return $name;
    }

    public function isServerExist($id)
    {
        $servers = $this->compute->listServers(true);
        foreach($servers as $server){
            if($server->id == $id){
                return true;
            }
        }
        return false;
    }
}
