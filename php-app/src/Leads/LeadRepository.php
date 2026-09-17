<?php

namespace App\Leads;

use App\Config\Database;
use PDO;

class LeadRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function create(
        string $firstName,
        string $lastName,
        string $phoneNumber,
        string $email,
        ?string $notes = null,
    ): string {
        $id = UuidGenerator::generate();

        $sql = "INSERT INTO leads (id, first_name, last_name, phone_number, email, notes)
            VALUES (:id, :first_name, :last_name, :phone_number, :email, :notes)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':phone_number' => $phoneNumber,
            ':email' => $email,
            ':notes' => $notes,
        ]);

        return $id;
    }

    public function fetchAll(): array
    {
        $sql = "SELECT * FROM leads;";
        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
