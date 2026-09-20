<?php

namespace App\Leads;

use App\Integrations\ExpressClient;

class LeadService
{
    private LeadRepository $repository;
    private ExpressClient $express;

    public function __construct()
    {
        $this->repository = new LeadRepository();
        $this->express = new ExpressClient();
    }

    /**
    * @param array $formData
    */
    public function captureLead(array $formData): string
    {
        $firstName = trim($formData['first_name'] ?? '');
        $lastName = trim($formData['last_name'] ?? '');
        $phoneNumber = trim($formData['phone_number'] ?? '');
        $email = trim($formData['email'] ?? '');
        $notes = trim($formData['notes'] ?? '') ?: null;

        if ($firstName === '' || $lastName === '' || $phoneNumber === '' || $email === '') {
            throw new \InvalidArgumentException('All fields, except notes, are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Please enter a valid email address.');
        }

        return $this->repository->create($firstName, $lastName, $phoneNumber, $email);

    }
    public function fetchAllLeads(): array
    {
        $leads = $this->repository->fetchAll();

        return $leads;
    }

    public function requestCall(string $leadId): bool
    {
        $lead = $this->repository->fetchById($leadId);

        if (!$lead) {
            throw new \InvalidArgumentException('Lead not found');
        }

        return $this->express->requestCall(
            $leadId,
            $lead['phoneNumber'],
        );

    }

}
