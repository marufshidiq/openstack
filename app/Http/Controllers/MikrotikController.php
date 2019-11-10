<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RouterOS\Client;
use RouterOS\Query;
use Auth;

class MikrotikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Initiate client with config object
        $this->client = new Client([
            'host' => env('MIKROTIK_HOST'),
            'user' => env('MIKROTIK_API_USER'),
            'pass' => env('MIKROTIK_API_PASSWORD')
        ]);
    }

    public function show()
    {
        $query = (new Query('/ip/firewall/nat/print'))->where('comment', Auth::user()->id_number);
        $ports = $this->client->query($query)->read();
        return view('port.show', compact('ports'));
    }

    public function delete($id)
    {
        $query = (new Query('/ip/firewall/nat/print'))->where('.id', $id);
        $response = $this->client->query($query)->read();
        if (count($response) != 1) {
            return redirect()->route('port.show');
        }
        if ($response[0]['comment'] != Auth::user()->id_number) {
            return redirect()->route('port.show');
        }
        $query = (new Query('/ip/firewall/nat/remove'))
            ->equal('numbers', $id);
        $response = $this->client->query($query)->read();
        return redirect()->route('port.show');
    }

    public function create()
    {
        return view('port.create');
    }

    public function createPort(Request $request)
    {
        $request->validate([
            'private_ip' => 'required|ipv4',
            'private_port' => 'required|digits_between:1,65536'
        ]);

        $can_used = false;
        $random = 0;
        while (!$can_used) {
            $random = random_int(10000, 60000);
            $query = (new Query('/ip/firewall/nat/print'))->where('dst-port', $random);
            $response = $this->client->query($query)->read();
            if(count($response) == 0){
                $can_used = true;
            }
        }

        $query = (new Query('/ip/firewall/nat/add'))
            ->equal('chain', 'dstnat')
            ->equal('protocol', '6')
            ->equal('dst-port', $random)
            ->equal('action', 'dst-nat')
            ->equal('to-addresses', $request->private_ip)
            ->equal('to-ports', $request->private_port)
            ->equal('comment', Auth::user()->id_number);

        $response = $this->client->query($query)->read();
        return redirect()->route('port.show');
    }
}
