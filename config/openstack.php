<?php

return [
    'keystone_url' => env('OPENSTACK_KEYSTONE_URL', 'http://controller:5000/v3'),
    'region' => env('OPENSTACK_REGION', 'RegionOne'),
    'user' => [
        'id' => env('OPENSTACK_USER_ID'),
        'password' => env('OPENSTACK_PASSWORD')
    ],
    'project' => [
        'id' => env('OPENSTACK_PROJECT_ID')
    ],

    'default' => [
        'authUrl' =>  env('OPENSTACK_KEYSTONE_URL'),
        'region'  => env('OPENSTACK_REGION'),
        'user'    => [
            'id'       => env('OPENSTACK_USER_ID'),
            'password' => env('OPENSTACK_PASSWORD')
        ],
        'scope'   => ['project' => ['id' => env('OPENSTACK_PROJECT_ID')]]
    ]
];