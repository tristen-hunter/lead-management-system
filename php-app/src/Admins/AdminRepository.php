<?php

namespace App\Admins;

use App\Config\Database;
use PDO;

class AdminRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
    * Fetches a admin row from the database by their email address.
    *
    * @param string $email The email address to look up.
    * @return array<string, mixed>|false Returns an associative array of the row if found,
    *                                    or false if no user exists or a query fails.
    */
    public function fetchAdminByEmail(string $email): array|false
    {
        $sql = "SELECT id, email, password_hash FROM admins WHERE email = :email";
        $stmt = $this->db->prepare($sql);

        $stmt->execute(['email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
