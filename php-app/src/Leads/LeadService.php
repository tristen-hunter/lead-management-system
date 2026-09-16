<?php

namespace App\Leads;

class LeadService
{
    private LeadRepository $repository;

    public function __construct()
    {
        $this->repository = new LeadRepository();
    }

    /**
    * @param array $formData
    */
    public function captureLead(array $formData): string
    {
        return $this->repository->create(
            $formData['first_name'],
            $formData['last_name'],
            $formData['phone_number'],
            $formData['email'],
            $formData['notes'] ?? null,
        );
    }
}
