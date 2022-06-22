<?php

use Illuminate\Support\Facades\Crypt;

if (! function_exists('getStoreFullUrl')) {
    function getStoreFullUrl($storeName) {
        return "https://$storeName";
    }

    function encryptStoreName($storeName) {
        return Crypt::encryptString($storeName);
    }

    function decryptStoreName($encrptedstoreName) {
        return Crypt::decryptString($encrptedstoreName);
    }
}