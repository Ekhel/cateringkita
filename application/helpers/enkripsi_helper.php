<?php

function encrypt($data = null)
{
    return openssl_encrypt($data, "AES-256-CBC", "Fx53l3r4x51n3rg1ali53l3r4xxM4rtx", NULL, "x51n3rg1x53l3r4x");
}

function decrypt($data = null)
{
    return openssl_decrypt($data, "AES-256-CBC", "Fx53l3r4x51n3rg1ali53l3r4xxM4rtx", NULL, "x51n3rg1x53l3r4x");
}

function kunci()
{
    return "Fx53l3r4x51n3rg1ali53l3r4xxM4rtx";
}

// function selectDataEnkripsi($field = null, $alias = null)
// {
//     $key = "Fx53l3r4x51n3rg1x+x53l3r4xxM4rtx";

//     return "CAST(AES_DECRYPT($field, '$key') AS CHAR(50)) $alias";
// }
