<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Notice;
use App\Models\HeroSlide;

class HomeController extends Controller {
    public function index(Request $request): void {
        $notices = Notice::getPublished(4);
        $urgentNotices = array_filter($notices, fn($n) => $n['is_urgent'] == 1);
        $heroSlides = HeroSlide::getPublishedSlides();
        
        $this->render('home/index', [
            'notices' => $notices,
            'urgentNotice' => reset($urgentNotices) ?: null,
            'heroSlides' => $heroSlides
        ]);
    }
}
