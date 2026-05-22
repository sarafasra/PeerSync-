<?php

namespace Src\Entities;

use Src\Enums\Status;
use Exception;

class HelpRequest {

    private int $id;
    private string $titre;
    private string $description;
    private string $technologie;
    private Status $statut;
    private int $idStudent;
    private ?int $idTutor;

    public function __construct(
        int $id,
        string $titre,
        string $description,
        string $technologie,
        Status $statut,
        int $idStudent,
        ?int $idTutor = null
    ) {

        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->technologie = $technologie;

        $this->statut = $statut;

        $this->idStudent = $idStudent;
        $this->idTutor = $idTutor;
    }

    // GETTERS

    public function getId(): int {
        return $this->id;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getTechnologie(): string {
        return $this->technologie;
    }

    public function getStatut(): Status {
        return $this->statut;
    }

    public function getIdStudent(): int {
        return $this->idStudent;
    }

    public function getIdTutor(): ?int {
        return $this->idTutor;
    }

    // ASSIGNATION

    public function assignTo(User $tutor): void {

        // empêcher auto assignation
        if ($tutor->getId() === $this->idStudent) {

            throw new Exception(
                "Impossible de s'assigner à soi-même"
            );
        }

        // empêcher double assignation
        if ($this->statut !== Status::EN_ATTENTE) {

            throw new Exception(
                "Ticket déjà assigné ou résolu"
            );
        }

        $this->idTutor = $tutor->getId();

        $this->statut = Status::ASSIGNE; 
    }

    // RESOLUTION

    public function resolve(): void {

        if ($this->statut !== Status::ASSIGNE) {

            throw new Exception(
                "Le ticket doit être assigné avant résolution"
            );
        }

        $this->statut = Status::RESOLUE;
    }
}