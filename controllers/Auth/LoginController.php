<?php
namespace App\Controllers\Auth;

class LoginController
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function execute()
    {
        // Identifiants administrateurs en clair comme demandé
        $admin_user = 'admin';
        $admin_pass = 'admin';

        if ($this->username === $admin_user && $this->password === $admin_pass) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin_user;
            return true;
        }

        return false;
    }
}
