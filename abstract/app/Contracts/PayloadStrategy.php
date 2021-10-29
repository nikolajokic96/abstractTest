<?php

namespace App\Contracts;

interface PayloadStrategy
{
    /**
     * Creates json payload
     *
     * @param array $payload
     * @return string
     */
    public function getPayload(array $payload): string;
}
