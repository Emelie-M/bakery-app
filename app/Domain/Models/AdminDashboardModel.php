<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class AdminDashboardModel extends BaseModel
{
    public function __construct(PDOService $db_service)
    {
        return parent::__construct($db_service);
    }

    public function getTotalProducts(): int
    {
        $sql = "SELECT COUNT(*) FROM PRODUCTS";
        return $this->count($sql);
    }

    public function getTotalCategories(): int
    {
        $sql = "SELECT COUNT(*) FROM CATEGORIES";
        return $this->count($sql);
    }
}
