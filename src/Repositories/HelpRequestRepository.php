<?php

namespace Src\Repositories;

use PDO;
use Config\Database;
use Src\Entities\HelpRequest;
use Src\Enums\Status;

class HelpRequestRepository {

    private PDO $pdo;

    public function __construct() {

        $this->pdo = Database::getInstance();
    }

    // CREATE

    public function create(HelpRequest $request): bool {

        $sql = "INSERT INTO help_requests
        (titre, description, technologie, statut, id_student, id_tutor)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $request->getTitre(),
            $request->getDescription(),
            $request->getTechnologie(),
            $request->getStatut()->value,
            $request->getIdStudent(),
            $request->getIdTutor()
        ]);
    }



    public function findAll(): array {

        $sql = "SELECT * FROM help_requests";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function findById(int $id): ?HelpRequest {

        $sql = "SELECT * FROM help_requests WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new HelpRequest(
            $data['id'],
            $data['titre'],
            $data['description'],
            $data['technologie'],
            Status::from($data['statut']),
            $data['id_student'],
            $data['id_tutor']
        );
    }

    // UPDATE

    public function update(HelpRequest $request): bool {

        $sql = "UPDATE help_requests
        SET statut = ?, id_tutor = ?
        WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $request->getStatut()->value,
            $request->getIdTutor(),
            $request->getId()
        ]);
    }
}