<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Verification;

class VerificationController extends Controller {
    public function index(Request $request): void {
        $query = $request->get('verification_query') ?? $request->post('verification_query');
        $record = null;
        $searched = false;

        if ($query) {
            $searched = true;
            $record = Verification::findByCode($query);
        }

        $this->render('verify/index', [
            'query' => $query,
            'searched' => $searched,
            'record' => $record
        ]);
    }
}
