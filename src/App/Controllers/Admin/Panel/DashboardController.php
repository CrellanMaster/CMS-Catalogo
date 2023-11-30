<?php

namespace Crellan\App\App\Controllers\Admin\Panel;

use Crellan\App\App\Controllers\BaseController;
use Crellan\App\Core\Services\AuthService;
use Crellan\App\Infra\Database\DatabaseConnection;

class DashboardController extends BaseController
{

    public function index()
    {
        $auth = new AuthService($this->db);
        $auth->checkSession();
        var_dump($_SESSION);
    }
}
