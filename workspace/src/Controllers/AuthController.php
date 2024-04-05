<?php

namespace Src\Controllers;

use Src\Models\Auth;
use Src\Models\Seo;

class AuthController extends Controller
{
    /**
     * Render login page and verify login form
     * 
     * @return void
     */
    public function login(): void
    {
        $loginInput = input("login");
        if (isset($loginInput)) {
            $this->verifyLoginForm();
        } else {
            $seo = new Seo(trans("admin_login"), "", "", "", "");
            echo view("/login.php", compact("seo"));
        }
    }

    /**
     * Verify login form
     * 
     * @return void
     */
    public function verifyLoginForm(): void
    {
        $email = input("email");
        $password = input("password");
        $errors = $this->attempt($email, $password);
        if (count($errors) === 0) {
            redirect("/");
        } else {
            flashFromArray($errors);
            redirect("/admin/login.html");
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
        $errors = [];
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors["email"] = trans("invalidate_email_error");
        }

        if (trim($password) === "") {
            $errors["password"] = trans("required_field_error");
        }

        if (count($errors) === 0) {
            $user = Auth::attempt($email, $password);
            if (!$user) $errors["email"] = trans("unauthorize_error");
        }

        return $errors;
    }
}
