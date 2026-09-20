<?php

namespace App\Integrations;

class ExpressClient
{
    public function requestCall(string $leadId, string $phoneNumber): array
    {
        $ch = curl_init('http://express-service:3000/calls');

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode([
                'leadId'      => $leadId,
                'phoneNumber' => $phoneNumber,
            ]),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
        ]);

        $response = curl_exec($ch);
        $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            throw new \RuntimeException("Could not reach Express: $error");
        }
        if ($status >= 400) {
            throw new \RuntimeException("Express returned $status: $response");
        }

        return json_decode($response, true) ?? [];
    }
}
