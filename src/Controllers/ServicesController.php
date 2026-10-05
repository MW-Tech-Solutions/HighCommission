<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class ServicesController extends Controller {
    public function index(Request $request): void {
        $this->render('consular/index');
    }

    public function fees(Request $request): void {
        $this->render('services/fees');
    }

    public function appointments(Request $request): void {
        $this->redirect('appointment');
    }
}
