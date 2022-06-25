<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function toast($type, $deskripsi)
{
    $data = array('response' => $type, 'message' => $deskripsi);

    return $data;
}
