<?php

namespace App\Controllers;

use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use DI\Container;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\SessionManager;

class AuthController extends BaseController
{
    public function __construct(Container $container, private UserModel $userModel)
    {
        parent::__construct($container);
    }

    /**
     * Display the registration form (GET /register).
     */
    public function register(Request $request, Response $response, array $args): Response
    {
        // TODO: Render the registration view with the title 'Create Account',
        $data = [
            'title' => "Create Account"
        ];

        return $this->render($response, "auth/register.php", $data);
    }
    /**
     * Process the registration form (POST /register).
     */
    public function store(Request $request, Response $response, array $args): Response
    {
        // TODO: Read the submitted fields, removing surrounding spaces from
        //       every field except the two passwords.
        $data = $request->getParsedBody();
        $firstName = trim($data['first_name']);
        $lastName = trim($data['last_name']);
        $username = trim($data['username']);
        $email = trim($data['email']);
        $password = $data['password'];
        $confirmPassword = $data['confirm_password'];
        $errors = [];
        $old = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'email' => $email
        ];
        // TODO: Check the fields against the rules in the table below and
        //       collect the message of every rule that fails.
        if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $errors[] = 'All fields are required!';
        } else {
            if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
                $errors[] = 'Invalid email format!';
            }
            if ($this->userModel->emailExists($email)) {
                $errors[] = 'Email already registered!';
            }
            if ($this->userModel->usernameExists($username)) {
                $errors[] = 'Username already taken!';
            }
            if (strlen($password) < 8) {
                $errors[] = 'Password must be at least 8 characters long!';
            }
            if (!preg_match('/\d/', $password)) {
                $errors[] = 'Password must contain at least one number!';
            }
            if ($password != $confirmPassword) {
                $errors[] = 'Password do not match!';
            }
        }


        // TODO: If any rule failed, redisplay the form with the errors and the
        //       submitted values (never the passwords), with status 422.
        if (!empty($errors)) {
            $data = [
                'title' => "Create Account",
                'errors' => $errors,
                'old' => $old,
            ];

            return $this->render($response, "auth/register.php", $data)->withStatus(422);
        }
        // TODO: Otherwise, create the user as a customer.
        //       If it succeeds, show a success message and send the user to the login form.
        //       If the database rejects the insert, show an error message and send
        //       the user back to the registration form.
        else {
            $data = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => 'customer'
            ];
            try {
                $this->userModel->createUser($data);
            } catch (PDOException $e) {
                FlashMessage::error("Registration failed. Please try again.");
                $data = [
                    'title' => "Create Account",
                    'errors' => $errors,
                    'old' => $old,
                ];
                return $this->render($response, "auth/register.php", $data)->withStatus(422);
            }
            FlashMessage::success('Your account has been created. You can now log in.');
            return $this->render($response, "auth/login.php");
        }
    }

    /**
     * Display the login form (GET /login).
     */
    public function login(Request $request, Response $response, array $args): Response
    {
        // TODO: If a failed login attempt left an identifier in the session,
        //       take it out of the session so it is only used once.
        $identifier = $_SESSION['identifier'] ?? '';
        unset($_SESSION['identifier']);
        // TODO: Render the login view with the title 'Login' and that identifier
        //       (an empty string if there is none).
        $data = [
            'title' => 'Login',
            'identifier' => $identifier
        ];
        return $this->render($response, "auth/login.php", $data);
    }

    /**
     * Process the login form (POST /login).
     */
    public function authenticate(Request $request, Response $response, array $args): Response
    {
        // TODO: Read the identifier and the password from the submitted form.
        $data = $request->getParsedBody();
        $identifier = $data['identifier'];
        $password = $data['password'];
        // TODO: If a field is empty or the credentials are invalid, remember the
        //       identifier in the session for login(), show "Invalid credentials.",
        //       and send the user back to the login form.
        if ($identifier == "" || $password == "" || !$this->userModel->verifyCredentials($identifier, $password)) {
            $_SESSION['identifier'] = $identifier;
            return $this->redirect($request, $response, 'auth.login');
        } else {
            $user = $this->userModel->verifyCredentials($identifier, $password);
        }
        // TODO: Protect the new login against session fixation (see Step 2).
        SessionManager::regenerate();
        // TODO: Store the user in the session (see the Session Keys table below).
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['is_authenticated'] = true;
        // TODO: Welcome the user and send them to the dashboard that matches their role.
        $name = $user['first_name'];
        $role = $user['role'];
        FlashMessage::success("Welcome $name!");
        if ($role == 'admin') {
            return $this->redirect($request, $response, 'admin.dashboard');
        } else {
            return $this->redirect($request, $response, 'user.dashboard');
        }
    }

    /**
     * Log the current user out (POST /logout).
     */
    public function logout(Request $request, Response $response, array $args): Response
    {
        // TODO: End the logged-in session without losing the next flash message
        //       (see the note below).
        $_SESSION['user_id'] = '';
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        unset($_SESSION['is_authenticated']);
        // TODO: Show "You have been logged out." and send the user to the login form.
        FlashMessage::success('You have been logged out.');
        return $this->redirect($request, $response, 'auth.login');
    }

    /**
     * Display the user dashboard (GET /dashboard, protected).
     */
    public function dashboard(Request $request, Response $response, array $args): Response
    {
        // TODO: Render 'user/dashboard.php' with 'title' => 'Dashboard'
        $data = [
            'title' => 'Dashboard'
        ];
        return $this->render($response, "user/dashboard.php", $data);
    }
}
