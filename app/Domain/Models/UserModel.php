<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use App\Helpers\FlashMessage;

class UserModel extends BaseModel
{
    public function __construct(PDOService $pdoService)
    {
        parent::__construct($pdoService);
    }

    /**
     * Insert a new user and return the new user's ID.
     *
     * $data contains the keys first_name, last_name, username, email,
     * password (plain text), and role.
     */
    public function createUser(array $data): int
    {
        $sql = "INSERT INTO users (first_name, last_name, username, email, password_hash, role) VALUES (:first_name, :last_name, :username, :email, :password_hash, :role)";
        $params = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role']
        ];

        $this->execute($sql, $params);
        return (int) $this->lastInsertId();
    }

    /**
     * Return the user with the given email address, or null if there is none.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->selectOne('SELECT * FROM users WHERE email = :email', ['email' => $email]) ?: null;
    }

    /**
     * Return the user with the given username, or null if there is none.
     */
    public function findByUsername(string $username): ?array
    {
        return $this->selectOne('SELECT * FROM users WHERE username = :username', ['username' => $username]) ?: null;
    }

    /**
     * Return true if a user with the given email address already exists.
     */
    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    /**
     * Return true if a user with the given username already exists.
     */
    public function usernameExists(string $username): bool
    {
        return $this->findByUsername($username) !== null;
    }

    /**
     * Verify user credentials by email/username and password.
     *
     * @param string $identifier Email or username
     * @param string $password Plain-text password to verify
     * @return array|null User data if credentials are valid, null otherwise
     */
    public function verifyCredentials(string $identifier, string $password): ?array
    {
        // TODO: Look up the user by their identifier (try email first, then username).
        //       If found, verify the password against the stored hash.
        //       Return the user data on success or null on failure.
        if ($this->emailExists($identifier) || $this->usernameExists($identifier)) {
            if ($this->emailExists($identifier)) {
                $user = $this->findByEmail($identifier);
            } else {
                $user = $this->findByUsername($identifier);
            }
            if (password_verify($password, $user['password_hash'])) {
                return $user;
            } else {
                FlashMessage::error("Username or password is incorrect!");
                return null;
            }
        } else {
            FlashMessage::error('Username or password is incorrect!');
            return null;
        }
    }
}
