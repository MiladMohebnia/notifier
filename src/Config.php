<?php

namespace notifier;

class Config
{

    public $endpoint;
    public $vendorKey;

    public function __construct($endpoint, $vendorKey)
    {
        if ($endpoint[strlen($endpoint) - 1] !== '/') {
            $endpoint .= "/";
        }
        $this->endpoint = $endpoint;
        $this->vendorKey = $vendorKey;
    }
}
