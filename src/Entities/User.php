<?php
namespace Src\Entities;

class User {

    private int $id;
    private string $nom;
    private string $email;
    private string $password;
    private string $role;

    public function __construct(
        int $id,
        string $nom,
        string $email,
        string $password,
        string $role
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getRole(): string { return $this->role; }
}