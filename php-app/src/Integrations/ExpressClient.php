<?php

namespace App\Integrations;

class ExpressClient
{
    public function requestCall(string $leadId, string $phoneNumber): bool
    {
        $data = [
            'leadId' => $leadId,
            'phoneNumber' => $phoneNumber,
        ];

        $json = json_encode($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://express-service:3000/calls');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return true;
    }
}
