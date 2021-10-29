<?php

namespace App\Utilities;

use App\Contracts\PayloadStrategy;

class JsonPayloadStrategy implements PayloadStrategy
{
    /**
     * Creates json payload
     *
     * @param array $payload
     * @return string
     */
    public function getPayload(array $payload): string
    {
        return json_encode($payload);
    }
}
