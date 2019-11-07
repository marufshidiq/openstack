<?php

function formatVNCURL($realURL)
{
    return str_replace(env('OPENSTACK_PRIVATE_VNC_URL'), env('OPENSTACK_PUBLIC_VNC_URL'), $realURL);
}