<?php

if (! function_exists('getStoreFullUrl')) {
    function getStoreFullUrl($storeName) {
        return "https://$storeName";
    }
}