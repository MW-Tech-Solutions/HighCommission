<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Helper;
use App\Core\Auth;
use App\Models\RequestModel;

class ContactController extends Controller {
    public function index(Request $request): void {
        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('contact');
            }

            $user = Auth::user();
            $ref = RequestModel::create([
                'user_id' => $user['id'] ?? null,
                'applicant_name' => $request->post('name'),
                'applicant_email' => $request->post('email'),
                'applicant_phone' => $request->post('phone'),
                'service_type' => 'general_enquiry',
                'subject' => $request->post('subject'),
                'details' => $request->post('message')
            ]);

            Helper::setFlash('success', "Your general enquiry has been submitted under Reference Number: {$ref}. High Commission officers will reply via email and in your portal.");
            $this->redirect('contact');
        }

        $this->render('contact/index');
    }
}
