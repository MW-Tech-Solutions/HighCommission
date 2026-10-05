/**
 * Nigeria High Commission Nairobi, Kenya - Core Application JavaScript
 * Vanilla ES6+ - Zero Framework Overheads
 */

document.addEventListener('DOMContentLoaded', function() {
    initFontResizer();
    initVisaQuiz();
    initStatesExplorer();
    initVerificationScanner();
    initHeroCarousel();
    initSidebarAutoScroll();
});

/**
 * 5. Admin-Managed Hero Carousel Pause/Play & Reduced Motion
 */
function initHeroCarousel() {
    const carouselEl = document.getElementById('nhcHeroCarousel');
    if (!carouselEl || typeof bootstrap === 'undefined') return;

    const carousel = bootstrap.Carousel.getOrCreateInstance(carouselEl, {
        interval: 4000,
        touch: true,
        pause: false,
        ride: 'carousel'
    });

    const toggleBtn = document.getElementById('heroCarouselToggleBtn');
    const toggleIcon = document.getElementById('heroCarouselToggleIcon');
    const toggleText = document.getElementById('heroCarouselToggleText');

    let isPausedByUser = false;

    // Reduced Motion Detection
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        carousel.pause();
        if (toggleIcon && toggleText) {
            toggleIcon.className = 'bi bi-play-fill me-1';
            toggleText.textContent = 'Play';
        }
    }

    if (toggleBtn && toggleIcon && toggleText) {
        toggleBtn.addEventListener('click', function() {
            if (isPausedByUser) {
                carousel.cycle();
                isPausedByUser = false;
                toggleIcon.className = 'bi bi-pause-fill me-1';
                toggleText.textContent = 'Pause';
                toggleBtn.setAttribute('aria-label', 'Pause slideshow');
            } else {
                carousel.pause();
                isPausedByUser = true;
                toggleIcon.className = 'bi bi-play-fill me-1';
                toggleText.textContent = 'Play';
                toggleBtn.setAttribute('aria-label', 'Play slideshow');
            }
        });
    }

    // Pause on focus enter
    carouselEl.addEventListener('focusin', function() {
        if (!isPausedByUser) carousel.pause();
    });

    carouselEl.addEventListener('focusout', function() {
        if (!isPausedByUser) carousel.cycle();
    });
}


/**
 * 1. Accessibility Font Resizer (A-, A, A+)
 */
function initFontResizer() {
    const btnDecrease = document.getElementById('btn-font-decrease');
    const btnReset = document.getElementById('btn-font-reset');
    const btnIncrease = document.getElementById('btn-font-increase');
    
    let currentFontSize = 100; // percent

    if (btnDecrease && btnReset && btnIncrease) {
        btnDecrease.addEventListener('click', function() {
            if (currentFontSize > 85) {
                currentFontSize -= 5;
                document.documentElement.style.fontSize = currentFontSize + '%';
            }
        });
        btnReset.addEventListener('click', function() {
            currentFontSize = 100;
            document.documentElement.style.fontSize = '100%';
        });
        btnIncrease.addEventListener('click', function() {
            if (currentFontSize < 125) {
                currentFontSize += 5;
                document.documentElement.style.fontSize = currentFontSize + '%';
            }
        });
    }
}

/**
 * 2. Visa Eligibility Quiz Widget
 */
function initVisaQuiz() {
    const quizForm = document.getElementById('visa-quiz-form');
    const quizResult = document.getElementById('visa-quiz-result');

    if (quizForm && quizResult) {
        quizForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const purpose = document.getElementById('quiz-purpose').value;
            const nationality = document.getElementById('quiz-nationality').value;
            const duration = document.getElementById('quiz-duration').value;

            let resultCategory = '';
            let details = '';

            if (purpose === 'tourism') {
                resultCategory = 'Short Visit / Tourist Visa (F5A)';
                details = 'Suitable for holidays, visiting relatives, or cultural tourism. Requires invitation or hotel booking, bank statement, and return flight ticket.';
            } else if (purpose === 'business') {
                resultCategory = 'Business Visa (F4A / F4B)';
                details = 'Designed for foreign entrepreneurs, investors, or corporate representatives attending conferences or business negotiations. Requires host company invitation in Nigeria.';
            } else if (purpose === 'employment') {
                resultCategory = 'Subject to Regularization (STR) Visa';
                details = 'For foreign expatriates taking up approved employment in Nigeria. Requires quota approval from Ministry of Interior.';
            } else if (purpose === 'temporary_work') {
                resultCategory = 'Temporary Work Permit (TWP)';
                details = 'For specialized technical assignments (machinery installation, audits, training). Requires Comptroller General of Immigration pre-approval.';
            } else {
                resultCategory = 'Standard Visitor Visa';
                details = 'Please consult High Commission consular staff for specific guidance.';
            }

            quizResult.innerHTML = `
                <div class="alert alert-emerald border-0 shadow-sm p-4 rounded-3 mt-3">
                    <h5 class="fw-bold text-emerald-dark mb-2"><i class="bi bi-patch-check-fill text-emerald me-2"></i>Recommended Visa Category: ${resultCategory}</h5>
                    <p class="mb-3 text-secondary">${details}</p>
                    <a href="${quizForm.dataset.visaUrl || '#'}" class="btn btn-emerald btn-sm rounded-2"><i class="bi bi-file-text me-1"></i>View Requirements & Apply</a>
                </div>
            `;
            quizResult.classList.remove('d-none');
        });
    }
}

/**
 * 3. Interactive Nigeria 36 States Explorer
 */
function initStatesExplorer() {
    const filterButtons = document.querySelectorAll('.state-zone-btn');
    const stateCards = document.querySelectorAll('.state-card-item');

    if (filterButtons.length > 0 && stateCards.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                filterButtons.forEach(b => b.classList.remove('btn-emerald', 'active'));
                filterButtons.forEach(b => b.classList.add('btn-outline-emerald'));
                
                this.classList.remove('btn-outline-emerald');
                this.classList.add('btn-emerald', 'active');

                const selectedZone = this.dataset.zone;
                stateCards.forEach(card => {
                    if (selectedZone === 'all' || card.dataset.zone === selectedZone) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }
}

/**
 * 4. Document Authenticator QR Scanner Simulator
 */
function initVerificationScanner() {
    const scanTrigger = document.getElementById('btn-scan-qr');
    const fileInput = document.getElementById('qr-file-input');
    const searchInput = document.getElementById('verification_query');

    if (scanTrigger && fileInput && searchInput) {
        scanTrigger.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                // Simulate decoding sample QR code reference
                searchInput.value = 'NHCK-2026-8849';
                const form = document.getElementById('verify-search-form');
                if (form) form.submit();
            }
        });
    }
}

/**
 * 6. Admin Sidebar Auto-scroll to Active Nav Item
 */
function initSidebarAutoScroll() {
    const sidebar = document.querySelector('.admin-sidebar');
    const activeLink = document.querySelector('.admin-sidebar .nav-link.active');
    if (sidebar && activeLink) {
        setTimeout(() => {
            activeLink.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }, 120);
    }
}
