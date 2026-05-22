<?php

namespace Src\Repositories;

use PDO;
use Src\Entities\User;
use Config\Database;

class UserRepository {

    private PDO $pdo;

    public function __construct() {

        $this->pdo = Database::getInstance();
    }

  

    public function findByEmail(string $email): ?User {

        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$email]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new User(
            $data['id'],
            $data['nom'],
            $data['email'],
            $data['password'],
            $data['role']
        );
    }

   

    public function findById(int $id): ?User {

        $sql = "SELECT * FROM users WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        } 

        return new User(
            $data['id'],
            $data['nom'], 
            $data['email'],
            $data['password'],
            $data['role']
        );
    }
}