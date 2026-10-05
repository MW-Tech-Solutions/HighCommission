<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Helper;
use App\Models\TradeMatchmaking;

class TradeController extends Controller {
    public function index(Request $request): void {
        if ($request->getMethod() === 'POST') {
            if (!Helper::validateCsrf($request->post('csrf_token'))) {
                Helper::setFlash('danger', 'Invalid security token.');
                $this->redirect('trade');
            }

            $ref = TradeMatchmaking::create([
                'company_name' => $request->post('company_name'),
                'contact_person' => $request->post('contact_person'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'country_origin' => $request->post('country_origin'),
                'sector' => $request->post('sector'),
                'business_description' => $request->post('business_description'),
                'investment_size' => $request->post('investment_size')
            ]);

            Helper::setFlash('success', "Trade matchmaking enquiry logged under Reference Code: {$ref}. The Kenya-Nigeria Economic Desk will respond to your submission.");
            $this->redirect('trade');
        }

        $this->render('trade/index');
    }
}
