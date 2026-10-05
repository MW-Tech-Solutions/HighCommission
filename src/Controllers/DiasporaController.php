<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Helper;
use App\Core\Auth;
use App\Models\DiasporaCitizen;
use App\Models\RequestModel;

class DiasporaController extends Controller {
    public function index(Request $request): void {
        $this->render('diaspora/index');
    }

    public function register(Request $request): void {
        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('diaspora/register');
            }

            $user = Auth::user();
            $regNum = DiasporaCitizen::create([
                'user_id' => $user['id'] ?? null,
                'full_name' => $request->post('full_name'),
                'gender' => $request->post('gender'),
                'dob' => $request->post('dob'),
                'passport_number' => $request->post('passport_number'),
                'nin' => $request->post('nin'),
                'kenya_address' => $request->post('kenya_address'),
                'kenya_county' => $request->post('kenya_county'),
                'occupation' => $request->post('occupation'),
                'employer_institution' => $request->post('employer_institution'),
                'emergency_contact_kenya' => $request->post('emergency_contact_kenya'),
                'emergency_phone_kenya' => $request->post('emergency_phone_kenya'),
                'emergency_contact_nigeria' => $request->post('emergency_contact_nigeria'),
                'emergency_phone_nigeria' => $request->post('emergency_phone_nigeria'),
                'state_of_origin' => $request->post('state_of_origin'),
                'lga' => $request->post('lga')
            ]);

            Helper::setFlash('success', "Registration submitted successfully! Your Official Diaspora Registration Reference Number is {$regNum}. High Commission officers will verify your details.");
            $this->redirect('portal/dashboard');
        }

        $this->render('diaspora/register');
    }

    public function emergency(Request $request): void {
        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('diaspora/emergency');
            }

            $user = Auth::user();
            $ref = RequestModel::create([
                'user_id' => $user['id'] ?? null,
                'applicant_name' => $request->post('name'),
                'applicant_email' => $request->post('email'),
                'applicant_phone' => $request->post('phone'),
                'service_type' => 'emergency_distress',
                'subject' => 'EMERGENCY DISTRESS BEACON ACTIVATED',
                'details' => "Location in Kenya: " . $request->post('location') . "\nDistress Type: " . $request->post('distress_type') . "\nSituation Details: " . $request->post('details'),
                'priority' => 'urgent'
            ]);

            Helper::setFlash('danger', "EMERGENCY BEACON TRANSMITTED! Reference: {$ref}. High Commission consular emergency desk has been alerted immediately.");
            $this->redirect('diaspora/emergency');
        }

        $this->render('diaspora/emergency');
    }
}
