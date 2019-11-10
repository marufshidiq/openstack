<?php

namespace App\Http\Controllers;

use App\Flavor;
use App\Image;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->openstack = new \OpenStack\OpenStack(config('openstack.default'));
        $this->compute = $this->openstack->computeV2(['region' => env('OPENSTACK_REGION')]);
    }

    public function synchronize()
    {
        $images = $this->compute->listImages(['status' => 'ACTIVE']);
        Image::truncate();

        foreach ($images as $image) {
            $image->retrieve();
            $i = new Image();
            $i->image_id = $image->id;
            $i->image_name = $image->name;
            $i->family = $image->metadata['family'];
            $i->version = $image->metadata['version'];
            $i->min_cpu = 1;
            $i->min_ram = $image->minRam;
            $i->min_hdd = $image->minDisk;
            $i->save();
        }

        $flavors = $this->compute->listFlavors();
        Flavor::truncate();

        foreach ($flavors as $flavor) {
            $flavor->retrieve();

            $f = new Flavor();
            $f->flavor_id = $flavor->id;
            $f->name = $flavor->name;
            $f->cpu = $flavor->vcpus;
            $f->ram = $flavor->ram;
            $f->hdd = $flavor->disk;
            $f->save();

        }
        echo "Oke";
    }
}
