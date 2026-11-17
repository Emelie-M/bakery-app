<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ProductsModel extends BaseModel
{
    public function __construct(PDOService $pdoService)
    {
        parent::__construct($pdoService);
    }

    /**
     * Fetch all products from the database.
     */
    public function getAll(): array
    {
        $sql = "SELECT id, name, price, stock_quantity, created_at FROM products ORDER BY created_at DESC";
        return $this->selectAll($sql);
    }

    /**
     * Fetch all categories for the product form dropdown.
     */
    public function getAllCategories(): array
    {
        $sql = "SELECT id, name FROM categories ORDER BY name ASC";
        return $this->selectAll($sql);
    }

    public function createAndGetId(array $data): string
    {
        // TODO: 1. Execute an INSERT query using $this->execute()
        //       - Insert: category_id, name, price, description, created_at
        //       - Use named parameters (:category_id, :name, :price, :description, :created_at)
        $sql = "INSERT INTO products (category_id, name, price, description) VALUES (:category_id, :name, :price, :description)";
        $params = [
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description']
        ];


        $this->execute($sql, $params);

        // TODO: 2. Return the last inserted ID using $this->lastInsertId()
        return $this->lastInsertId();
    }

    public function findById(int $id): array|false
    {
        $sql = "SELECT id, category_id, name, price, description, stock_quantity, created_at FROM products WHERE ID = {$id}";
        if ($this->selectAll($sql) === []) {
            return false;
        }
        return $this->selectAll($sql);

        // TODO: Execute a SELECT query to fetch a single product by ID
        //       - Return the product as an associative array, or false if not found
    }

    public function update(int $id, array $data): int
    {
        $sql = "UPDATE products SET category_id = :category_id, name = :name, price = :price, description = :description WHERE id = :id";
        $params = [
            'category_id' => $data['category_id'],
            'name'        => $data['name'],
            'price'       => $data['price'],
            'description' => $data['description'],
            'id' => $id
        ];

        return $this->execute($sql, $params);


        // TODO: Execute an UPDATE query
        //       - Update: category_id, name, price, description
        //       - Use named parameters (:category_id, :name, :price, :description, :id)
        //       - Return the number of affected rows
    }

    public function delete(int $id): int
    {
        // TODO: Execute a DELETE query using $this->execute()
        //       - Use a WHERE clause with named parameter :id
        //       - Return the number of affected rows
        $sql = "DELETE FROM products WHERE id = :id";

        $params = [
            'id' => $id
        ];

        return $this->execute($sql, $params);
    }

    /**
     * Return the file path of the product's primary image, or null if it has none.
     */
    public function getPrimaryImage(int $productId): ?string
    {
        // TODO: Select the file_path of the product's image where is_primary is 1.
        //       Return the path, or null if there is no row.
        $sql = "SELECT file_path FROM product_images WHERE product_id = :id AND is_primary = 1";
        $params = [
            'id' => $productId
        ];

        if ($this->selectAll($sql, $params) === []) {
            return null;
        } else {
            return $this->selectOne($sql, $params);
        }
    }

    /**
     * Save a new image for the product and make it the primary image.
     */
    public function setPrimaryImage(int $productId, string $filePath): void
    {
        // TODO: 1. Mark all existing images of this product as not primary.
        $sql = "UPDATE product_images SET is_primary = 0 WHERE product_id = :id";
        $params = [
            'id' => $productId
        ];
        $this->execute($sql, $params);

        // TODO: 2. Insert the new image with is_primary set to 1.
        $sql = "INSERT INTO product_images (product_id, file_path, is_primary) VALUES (:product_id, :file_path, 1)";
        $params = [
            'product_id' => $productId,
            'file_path' => $filePath
        ];
        $this->execute($sql, $params);
    }
}
