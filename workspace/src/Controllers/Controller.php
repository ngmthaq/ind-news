<?php

namespace Src\Controllers;

use Src\Configs\Csrf;
use Src\Configs\Throttle;
use Src\Models\Auth;

abstract class Controller
{
    public function __construct()
    {
        Throttle::resolve();
        Csrf::init();
        Csrf::check();
        $this->getOldFormData();
    }

    /**
     * Check auth and permission
     * 
     * @return void
     */
    protected function checkAuthAndPermission(): void
    {
        $user = Auth::user();
        if (empty($user)) redirect("/login.html", ["callbackUrl" => getCurrentUrl()]);
        if ($user->isActive() === false) redirect("/email/verify.html");
    }

    /**
     * Handle set old form data
     * 
     * @return void
     */
    private function getOldFormData(): void
    {
        if (empty($_SESSION["_old"])) $_SESSION["_old"] = [];
        if (strtoupper($_SERVER["REQUEST_METHOD"]) === "POST") {
            foreach (input() as $name => $value) {
                old($name, $value);
            }
        }
    }
}
