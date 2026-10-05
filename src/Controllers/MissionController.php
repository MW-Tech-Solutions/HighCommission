<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class MissionController extends Controller {
    public function index(Request $request): void {
        $this->render('mission/index');
    }

    public function leadership(Request $request): void {
        $this->render('mission/leadership');
    }

    public function history(Request $request): void {
        $this->render('mission/history');
    }

    public function message(Request $request): void {
        $this->render('mission/message');
    }

    public function friends(Request $request): void {
        $this->render('mission/friends');
    }
}
