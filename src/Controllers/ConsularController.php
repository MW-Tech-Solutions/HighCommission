<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Helper;
use App\Core\Auth;
use App\Models\RequestModel;

class ConsularController extends Controller {
    public function index(Request $request): void {
        $this->render('consular/index');
    }

    public function passport(Request $request): void {
        $this->render('consular/passport');
    }

    public function visa(Request $request): void {
        $this->render('consular/visa');
    }

    public function etc(Request $request): void {
        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('consular/etc');
            }

            $user = Auth::user();
            $ref = RequestModel::create([
                'user_id' => $user['id'] ?? null,
                'applicant_name' => $request->post('applicant_name'),
                'applicant_email' => $request->post('applicant_email'),
                'applicant_phone' => $request->post('applicant_phone'),
                'service_type' => 'etc',
                'subject' => 'Emergency Travel Certificate Draft Application',
                'details' => "Reason for ETC: " . $request->post('reason') . "\nTravel Date: " . $request->post('travel_date') . "\nDestination: " . $request->post('destination') . "\nDetails: " . $request->post('details'),
                'priority' => 'urgent'
            ]);

            Helper::setFlash('success', "Your Emergency Travel Certificate draft request has been logged successfully under Reference Number: {$ref}. You can track progress in your Portal.");
            $this->redirect('portal/dashboard');
        }

        $this->render('consular/etc');
    }

    public function legalization(Request $request): void {
        $this->render('consular/legalization');
    }
}
