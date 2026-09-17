<?php

namespace App\Admins;

class AdminService
{
    private AdminRepository $repository;

    public function __construct()
    {
        $this->repository = new AdminRepository();
    }

    /*
     *@param array $formData
     */
    public function handleAdminLogin(array $formData): bool
    {
        $admin = $this->repository->fetchAdminByEmail($formData['email']);

        if ($admin === false) {
            throw new \InvalidArgumentException("Admin with email %s doesn't exist", $formData['email']);
        }

        if (!password_verify($formData['password'], $admin['password_hash'])) {
            throw new \InvalidArgumentException("Password is incorrect!");
        }

        return true;
    }
}
