<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ShopsModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        return parent::__construct($db_service);
    }

    public function getAllCafes(): array
    {
        $sql = "SELECT * FROM cafes";
        return $this->selectAll($sql);
    }

    public function getCafeById(int $id): array
    {
        $sql = "SELECT * FROM cafes WHERE ID={$id}";
        return $this->selectOne($sql);
    }
}
