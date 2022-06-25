<?php
function replace_phone_number($no_hp)
{
    $no = substr($no_hp, 0, 1);
    if ($no == "0") {
        $no_hp = substr_replace($no_hp, '62', 0, 1);
    } else {
        $no_hp = $no_hp;
    }

    return $no_hp;
}
