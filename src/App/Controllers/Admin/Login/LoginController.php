<?php

namespace Crellan\App\App\Controllers\Admin\Login;

use Crellan\App\App\Controllers\BaseController;
use Crellan\App\App\Models\Admin\UserModel;
use Crellan\App\Core\Entities\Admin\User;

class LoginController extends BaseController
{
    public function index()
    {
        var_dump("123");
    }

    public function registerUser()
    {
        $user = new User(
            "Sansdro",
            password_hash("12345", PASSWORD_BCRYPT),
            "sandro4@gmail.com",
            $_SERVER["REMOTE_ADDR"],
            1
        );
        $user->create();
    }

    public function forgotPassword()
    {
    }

    public function sendToken()
    {
        $_POST["email"] = filter_input("sandro@gmail.com", FILTER_SANITIZE_EMAIL);
        if (!isset($_POST["email"])) {
            return;
        }

        $userModel = new UserModel();
        $dataResult = $userModel->getUserByEmail($_POST["email"]);
        if (property_exists($dataResult, "rowCount") && $dataResult->rowCount > 0) {
        } else {
            return;
        }
    }

    public function redefinePassword()
    {
    }
}
