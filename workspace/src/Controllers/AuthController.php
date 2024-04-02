<?php

namespace Src\Controllers;

class AuthController extends Controller
{
    /**
     * Render login page
     * 
     * @return void
     */
    public function login(): void
    {
        $loginInput = input("login");
        if (isset($loginInput)) {
            $email = input("email");
            $password = input("password");
            $errors = $this->attempt($email, $password);
            if (count($errors) === 0) {
                // Success
            } else {
                // Fail
            }
        } else {
            echo view("/login.php");
        }
    }

    /**
     * Handle verify user login
     * Return empty array = login successfully
     * Return error details array = login failure
     * 
     * @param string $email
     * @param string $password
     * @return array
     */
    private function attempt(string $email, string $password): array
    {
        return [];
    }
}
