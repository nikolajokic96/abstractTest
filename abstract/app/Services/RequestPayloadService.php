<?php

namespace App\Services;

use App\Contracts\PayloadStrategy;

class RequestPayloadService
{
    /**
     * @var PayloadStrategy
     */
    private PayloadStrategy $payloadStrategy;

    /**
     * @param PayloadStrategy $payloadStrategy
     */
    public function __construct(PayloadStrategy $payloadStrategy)
    {
        $this->payloadStrategy = $payloadStrategy;
    }

    /**
     * Creates payload
     *
     * @param string $filePath
     * @return string
     */
    public function createPayload(string $filePath): string
    {
        $payload = [
            'filePath' => $filePath
        ];

        return $this->payloadStrategy->getPayload($payload);
    }


}
