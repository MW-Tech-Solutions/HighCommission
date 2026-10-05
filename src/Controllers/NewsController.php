<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Notice;

class NewsController extends Controller {
    public function index(Request $request): void {
        $notices = Notice::getPublished(20);
        $this->render('news/index', ['notices' => $notices]);
    }

    public function view(Request $request): void {
        $slug = $request->get('slug');
        $notice = Notice::findBySlug($slug);

        if (!$notice) {
            $this->redirect('news');
        }

        $this->render('news/view', ['notice' => $notice]);
    }
}
