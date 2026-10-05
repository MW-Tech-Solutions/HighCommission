<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Helper;
use App\Core\Auth;
use App\Models\Appointment;

class AppointmentController extends Controller {
    public function index(Request $request): void {
        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('appointment');
            }

            try {
                $user = Auth::user();
                $voucher = Appointment::create([
                    'user_id' => $user['id'] ?? null,
                    'applicant_name' => $request->post('applicant_name'),
                    'applicant_email' => $request->post('applicant_email'),
                    'applicant_phone' => $request->post('applicant_phone'),
                    'service_category' => $request->post('service_category'),
                    'appointment_date' => $request->post('appointment_date'),
                    'time_slot' => $request->post('time_slot'),
                    'notes' => $request->post('notes')
                ]);

                Helper::setFlash('success', "Appointment reserved successfully! Your Voucher Number is {$voucher}.");
                $this->redirect('appointment/voucher?code=' . $voucher);
            } catch (\Exception $e) {
                Helper::setFlash('danger', $e->getMessage());
                $this->redirect('appointment');
            }
        }

        $this->render('appointment/index');
    }

    public function voucher(Request $request): void {
        $code = $request->get('code');
        $appointment = Appointment::findByVoucher($code);

        if (!$appointment) {
            Helper::setFlash('warning', 'Appointment voucher not found.');
            $this->redirect('appointment');
        }

        $this->render('appointment/voucher', ['appointment' => $appointment]);
    }
}
