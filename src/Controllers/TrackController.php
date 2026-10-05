<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\RequestModel;
use App\Models\Appointment;

class TrackController extends Controller {
    public function index(Request $request): void {
        $ref = $request->get('ref') ?? $request->post('ref');
        $result = null;
        $type = null;

        if ($ref) {
            $ref = trim($ref);
            if (strpos(strtoupper($ref), 'APT') === 0) {
                $result = Appointment::findByVoucher($ref);
                $type = 'appointment';
            } else {
                $result = RequestModel::findByReference($ref);
                $type = 'request';
            }
        }

        $this->render('track/index', [
            'ref' => $ref,
            'result' => $result,
            'type' => $type
        ]);
    }
}
