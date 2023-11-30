<?php

namespace Crellan\App\App\Controllers\Admin\Auth;

use Crellan\App\App\Controllers\BaseController;
use Crellan\App\Core\Enums\AuthMessageEnum;
use Crellan\App\Core\Services\AuthService;
use Crellan\App\Infra\Database\DatabaseConnection;

class AuthController extends BaseController
{

    public function authLogin()
    {
        $auth = new AuthService($this->db);
        $auth->verifySessionToLogin();
        $email = "email2@email.com.br";
        $passkey = "123qwe";
        $user = $auth->AuthUser($email, $passkey);
        if ($user) {
            $auth->GenerateSession($user);
        } else {
            AuthMessageEnum::FAILED_LOGIN;
        }
    }
}
