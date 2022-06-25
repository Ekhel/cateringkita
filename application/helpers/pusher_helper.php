<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function pusher($pesan = "")
{
    require __DIR__ . '/../../vendor/autoload.php';

    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        'e4a0170caedeadc1ca35',
        '41b1ed7a2ddb7469cb41',
        '1127158',
        $options
    );

    $data['message'] = $pesan;
    $pusher->trigger('my-channel', 'my-event', $data);
}
