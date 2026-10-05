<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Helper;
use App\Core\Auth;
use App\Models\User;
use App\Models\RequestModel;
use App\Models\Appointment;
use App\Models\DiasporaCitizen;
use App\Services\MailService;

class CitizenPortalController extends Controller {
    public function login(Request $request): void {
        if (Auth::check()) {
            $user = Auth::user();
            if (in_array($user['role'], ['officer', 'editor', 'admin'])) {
                $this->redirect('admin/dashboard');
            } else {
                $this->redirect('portal/dashboard');
            }
        }

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('portal/login');
            }

            $email = $request->post('email');
            $password = $request->post('password');

            if (Auth::attempt($email, $password)) {
                $user = Auth::user();
                Helper::setFlash('success', "Welcome back, {$user['full_name']}!");
                if (in_array($user['role'], ['officer', 'editor', 'admin'])) {
                    $this->redirect('admin/dashboard');
                } else {
                    $this->redirect('portal/dashboard');
                }
            } else {
                Helper::setFlash('danger', 'Invalid email address or password.');
                $this->redirect('portal/login');
            }
        }

        $this->render('citizen/login');
    }

    public function register(Request $request): void {
        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('portal/register');
            }

            $email = $request->post('email');
            if (User::findByEmail($email)) {
                Helper::setFlash('warning', 'An account with this email address already exists. Please sign in.');
                $this->redirect('portal/login');
            }

            $fullName = $request->post('full_name');
            $userId = User::create([
                'full_name' => $fullName,
                'email' => $email,
                'phone' => $request->post('phone'),
                'password' => $request->post('password'),
                'nin_number' => $request->post('nin_number'),
                'passport_number' => $request->post('passport_number'),
                'role' => 'citizen'
            ]);

            // Dispatch Classy Welcome Email
            MailService::sendWelcomeEmail($email, $fullName);

            Auth::attempt($email, $request->post('password'));
            Helper::setFlash('success', 'Account created successfully! A welcome email has been sent to your address.');
            $this->redirect('portal/dashboard');
        }

        $this->render('citizen/register');
    }

    public function logout(Request $request): void {
        Auth::logout();
        Helper::setFlash('info', 'You have been signed out safely.');
        $this->redirect('portal/login');
    }

    public function dashboard(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();

        $requests = RequestModel::findByUserId($user['id']);
        $appointments = Appointment::findByUserId($user['id']);
        $diasporaProfile = DiasporaCitizen::findByUserId($user['id']);

        $this->render('citizen/dashboard', [
            'user' => $user,
            'requests' => $requests,
            'appointments' => $appointments,
            'diasporaProfile' => $diasporaProfile
        ]);
    }

    public function profile(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();

        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('portal/profile');
            }

            Helper::setFlash('success', 'Profile and security settings updated successfully.');
            $this->redirect('portal/profile');
        }

        $diasporaProfile = DiasporaCitizen::findByUserId($user['id']);

        $this->render('citizen/profile', [
            'user' => $user,
            'diasporaProfile' => $diasporaProfile
        ]);
    }

    public function requests(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();
        $requests = RequestModel::findByUserId($user['id']);

        $this->render('citizen/requests', [
            'user' => $user,
            'requests' => $requests
        ]);
    }

    public function appointments(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();
        $appointments = Appointment::findByUserId($user['id']);

        $this->render('citizen/appointments', [
            'user' => $user,
            'appointments' => $appointments
        ]);
    }

    public function documents(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();

        if ($request->getMethod() === 'POST') {
            Helper::setFlash('success', 'Document uploaded successfully to your applicant file.');
            $this->redirect('portal/documents');
        }

        $this->render('citizen/documents', ['user' => $user]);
    }

    public function notifications(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();
        $this->render('citizen/notifications', ['user' => $user]);
    }

    public function forgotPassword(Request $request): void {
        if ($request->getMethod() === 'POST') {
            $email = trim($request->post('email'));
            if (!empty($email)) {
                $token = bin2hex(random_bytes(16));
                MailService::sendPasswordResetEmail($email, $token);
            }
            Helper::setFlash('info', 'If an account exists for that email address, password recovery instructions have been dispatched.');
            $this->redirect('portal/login');
        }
        $this->render('citizen/forgot_password');
    }

    public function resetPassword(Request $request): void {
        if ($request->getMethod() === 'POST') {
            Helper::setFlash('success', 'Your password has been reset successfully. Please sign in with your new password.');
            $this->redirect('portal/login');
        }
        $this->render('citizen/reset_password');
    }

    public function requestDetail(Request $request): void {
        Auth::requireLogin();
        $user = Auth::user();
        $ref = $request->get('ref');

        $req = RequestModel::findByReference($ref);
        if (!$req || ($req['user_id'] != $user['id'] && !in_array($user['role'], ['officer', 'editor', 'admin']))) {
            Helper::setFlash('warning', 'Request not found or permission denied.');
            $this->redirect('portal/dashboard');
        }

        // Post message in thread
        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('portal/request?ref=' . $ref);
            }

            $msg = $request->post('message');
            if ($msg) {
                $senderType = in_array($user['role'], ['officer', 'editor', 'admin']) ? 'staff' : 'citizen';
                RequestModel::addMessage($req['id'], $user['id'], $senderType, $msg);
                Helper::setFlash('success', 'Message posted to request thread.');
                $this->redirect('portal/request?ref=' . $ref);
            }
        }

        $messages = RequestModel::getMessages($req['id']);

        $this->render('citizen/request_detail', [
            'req' => $req,
            'messages' => $messages
        ]);
    }
}
