<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/function.php';

class AuthController {

    public function login($email, $password) {
        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && md5($password) === $user['password']) {

            // SET SESSION
            $_SESSION['user'] = $user;

            // REDIRECT
            if ($user['role'] == 'admin') {
                header("Location: /Laundry-Web/app/views/admin/dashboard.php");
            } else {
                header("Location: /Laundry-Web/app/views/user/dashboard.php");
            }

            exit;
        }

        return "Email / Password salah!";
    }

    public function register($data) {
        $userModel = new User();

        $data['phone'] = formatPhone($data['phone']);

        $success = $userModel->create($data);

        if ($success) {
            return "Register berhasil, silakan login!";
        }

        return "Register gagal!";
    }
}