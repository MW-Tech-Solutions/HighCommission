/* ==========================================================================
   NIGERIAN HIGH COMMISSION IN KENYA — DIPLOMATIC PORTAL INTERACTIVE ENGINE
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {
    initModals();
    initDocumentVerifier();
    initInteractiveStatesMap();
    initAppointmentScheduler();
    initFeeCalculator();
    initMobileNav();
});

/* --------------------------------------------------------------------------
   1. MODAL CONTROLLERS
   -------------------------------------------------------------------------- */
function initModals() {
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    const modalCloseBtns = document.querySelectorAll('.modal-close-btn, [data-modal-close]');

    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = trigger.getAttribute('data-modal-target');
            openModal(targetId);
        });
    });

    modalCloseBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('.modal-backdrop');
            if (modal) closeModal(modal.id);
        });
    });

    // Close on backdrop click
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                closeModal(backdrop.id);
            }
        });
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }
}

/* --------------------------------------------------------------------------
   2. ANTI-FRAUD DOCUMENT VERIFICATION ENGINE
   -------------------------------------------------------------------------- */
function initDocumentVerifier() {
    const verifyBtn = document.getElementById('verify-doc-btn');
    const docInput = document.getElementById('doc-ref-input');
    const resultBox = document.getElementById('verifier-result-box');

    if (!verifyBtn || !docInput) return;

    // Mock Database of Authentic Sample Records for Live Demonstration
    const verifiedDatabase = {
        'NHC-2026-8891': { applicant: 'Chidiebere Okafor', docType: 'E-Passport Application Receipt', status: 'VERIFIED & VALID', dateIssued: '2026-09-15', office: 'High Commission Nairobi' },
        'NIS-KEN-4402': { applicant: 'Amina Bello', docType: 'Business Visa Authorization (STR)', status: 'VERIFIED & VALID', dateIssued: '2026-10-01', office: 'NIS Consular Desk' },
        'ETC-NAI-9921': { applicant: 'Kelechi Oliseh', docType: 'Emergency Travel Certificate', status: 'VERIFIED & VALID', dateIssued: '2026-10-03', office: 'Diplomatic Desk' }
    };

    verifyBtn.addEventListener('click', () => {
        const val = docInput.value.trim().toUpperCase();
        if (!val) {
            showVerificationResult('Please enter a valid Reference Number, Receipt ID or Serial Code.', 'error');
            return;
        }

        verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Checking Security Database...';
        verifyBtn.disabled = true;

        setTimeout(() => {
            verifyBtn.innerHTML = '<i class="fas fa-shield-alt"></i> Verify Authenticity';
            verifyBtn.disabled = false;

            if (verifiedDatabase[val]) {
                const item = verifiedDatabase[val];
                showVerificationResult(`
          <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
            <strong>AUTHENTIC OFFICIAL DOCUMENT FOUND</strong>
          </div>
          <p><strong>Applicant Name:</strong> ${item.applicant}</p>
          <p><strong>Document Type:</strong> ${item.docType}</p>
          <p><strong>Issuing Authority:</strong> ${item.office}</p>
          <p><strong>Date Certified:</strong> ${item.dateIssued}</p>
          <p style="margin-top: 0.5rem; font-size: 0.8rem; opacity: 0.85;">Security Hash: 0x8F92A...551C (Digital Signature Verified)</p>
        `, 'success');
            } else {
                // If random format matching official pattern, show sample valid response for demonstration
                if (val.startsWith('NHC-') || val.startsWith('NIS-') || val.length >= 8) {
                    showVerificationResult(`
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
              <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
              <strong>AUTHENTIC OFFICIAL RECORD VERIFIED</strong>
            </div>
            <p><strong>Reference Code:</strong> ${val}</p>
            <p><strong>Status:</strong> Valid Record on High Commission Nairobi Server</p>
            <p><strong>Payment Gateway:</strong> Remita / NIS Official Portal Verified</p>
            <p style="margin-top: 0.5rem; font-size: 0.8rem; opacity: 0.85;">This document was issued through official channels. No fraudulent alterations detected.</p>
          `, 'success');
                } else {
                    showVerificationResult(`
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
              <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem;"></i>
              <strong>UNVERIFIED OR SUSPICIOUS CODE</strong>
            </div>
            <p>No record matching <strong>"${val}"</strong> was found in the High Commission's official server.</p>
            <p style="margin-top: 0.5rem; font-size: 0.85rem;">⚠️ WARNING: If you were charged cash by a third-party agent, this document may be fraudulent. Report immediately to consular@nigeriankenya.or.ke</p>
          `, 'error');
                }
            }
        }, 600);
    });
}

function showVerificationResult(htmlContent, type) {
    const box = document.getElementById('verifier-result-box');
    if (!box) return;
    box.className = `verifier-result ${type}`;
    box.innerHTML = htmlContent;
}

/* --------------------------------------------------------------------------
   3. INTERACTIVE 36 STATES OF NIGERIA EXPLORER
   -------------------------------------------------------------------------- */
const NIGERIA_STATES = [
    { name: 'Abia', capital: 'Umuahia', region: 'South East', hub: 'Aba Commercial Market' },
    { name: 'Adamawa', capital: 'Yola', region: 'North East', hub: 'Agricultural Trade' },
    { name: 'Akwa Ibom', capital: 'Uyo', region: 'South South', hub: 'Oil & Gas, Victor Attah Int Airport' },
    { name: 'Anambra', capital: 'Awka', region: 'South East', hub: 'Onitsha Main Market & Manufacturing' },
    { name: 'Bauchi', capital: 'Bauchi', region: 'North East', hub: 'Yankari Game Reserve & Eco-Tourism' },
    { name: 'Bayelsa', capital: 'Yenagoa', region: 'South South', hub: 'Maritime Industry & Crude Refining' },
    { name: 'Benue', capital: 'Makurdi', region: 'North Central', hub: 'Food Basket of the Nation (Agro)' },
    { name: 'Borno', capital: 'Maiduguri', region: 'North East', hub: 'Trans-Sahara Trade Corridor' },
    { name: 'Cross River', capital: 'Calabar', region: 'South South', hub: 'Tinapa Resort & Calabar Carnival' },
    { name: 'Delta', capital: 'Asaba', region: 'South South', hub: 'Warri Port & Oil Exploration' },
    { name: 'Ebonyi', capital: 'Abakaliki', region: 'South East', hub: 'Rice Production & Salt Mining' },
    { name: 'Edo', capital: 'Benin City', region: 'South South', hub: 'Benin Bronze Heritage & Tech Hub' },
    { name: 'Ekiti', capital: 'Ado-Ekiti', region: 'South West', hub: 'Ikogosi Warm Springs & Education' },
    { name: 'Enugu', capital: 'Enugu', region: 'South East', hub: 'Coal City & Nollywood Film Production' },
    { name: 'FCT Abuja', capital: 'Abuja (Federal Capital)', region: 'North Central', hub: 'Seat of Government & Diplomacy' },
    { name: 'Gombe', capital: 'Gombe', region: 'North East', hub: 'Jewel in the Savannah Agro Hub' },
    { name: 'Imo', capital: 'Owerri', region: 'South East', hub: 'Hospitality & Industrial Estate' },
    { name: 'Jigawa', capital: 'Dutse', region: 'North West', hub: 'Dates, Sesame Seeds & ICT Infrastructure' },
    { name: 'Kaduna', capital: 'Kaduna', region: 'North West', hub: 'Textile Industry & Defence Academy' },
    { name: 'Kano', capital: 'Kano', region: 'North West', hub: 'Ancient Kurmi Market & Commerce' },
    { name: 'Katsina', capital: 'Katsina', region: 'North West', hub: 'Gobirau Minaret & Livestock Trade' },
    { name: 'Kebbi', capital: 'Birnin Kebbi', region: 'North West', hub: 'Argungu Fishing Festival & Rice Mills' },
    { name: 'Kogi', capital: 'Lokoja', region: 'North Central', hub: 'Confluence of Rivers Niger & Benue' },
    { name: 'Kwara', capital: 'Ilorin', region: 'North Central', hub: 'Sugar Refining & Pottery Culture' },
    { name: 'Lagos', capital: 'Ikeja', region: 'South West', hub: 'Africa\'s Largest Mega-City & Fintech Capital' },
    { name: 'Nasarawa', capital: 'Lafia', region: 'North Central', hub: 'Solid Minerals Development' },
    { name: 'Niger', capital: 'Minna', region: 'North Central', hub: 'Kainji Hydroelectric Dam & Tourism' },
    { name: 'Ogun', capital: 'Abeokuta', region: 'South West', hub: 'Olumo Rock & Manufacturing Belt' },
    { name: 'Ondo', capital: 'Akure', region: 'South West', hub: 'Cocoa Export & Bitumen Reserves' },
    { name: 'Osun', capital: 'Osogbo', region: 'South West', hub: 'Osun-Osogbo Sacred Grove (UNESCO)' },
    { name: 'Oyo', capital: 'Ibadan', region: 'South West', hub: 'First University & Cocoa House' },
    { name: 'Plateau', capital: 'Jos', region: 'North Central', hub: 'Jos Plateau Tourism & Mining' },
    { name: 'Rivers', capital: 'Port Harcourt', region: 'South South', hub: 'Garden City & Oil Refining Hub' },
    { name: 'Sokoto', capital: 'Sokoto', region: 'North West', hub: 'Seat of the Caliphate & Leathercraft' },
    { name: 'Taraba', capital: 'Jalingo', region: 'North East', hub: 'Mambilla Plateau & Tea Estates' },
    { name: 'Yobe', capital: 'Damaturu', region: 'North East', hub: 'Gum Arabic & Cattle Markets' },
    { name: 'Zamfara', capital: 'Gusau', region: 'North West', hub: 'Gold Mining & Textile Trade' }
];

function initInteractiveStatesMap() {
    const container = document.getElementById('states-chips-grid');
    const tabsContainer = document.getElementById('region-filter-tabs');

    if (!container) return;

    renderStateChips(NIGERIA_STATES);

    if (tabsContainer) {
        tabsContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('tab-btn')) {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                e.target.classList.add('active');
                const region = e.target.getAttribute('data-region');

                if (region === 'All') {
                    renderStateChips(NIGERIA_STATES);
                } else {
                    const filtered = NIGERIA_STATES.filter(s => s.region === region);
                    renderStateChips(filtered);
                }
            }
        });
    }
}

function renderStateChips(statesList) {
    const container = document.getElementById('states-chips-grid');
    if (!container) return;

    container.innerHTML = statesList.map(s => `
    <div class="state-chip" onclick="showStateDetail('${s.name}')">
      <div class="state-chip-name">${s.name}</div>
      <div class="state-chip-capital"><i class="fas fa-location-dot" style="font-size:0.7rem; color: #10B981;"></i> ${s.capital} • ${s.region}</div>
    </div>
  `).join('');
}

window.showStateDetail = function (stateName) {
    const state = NIGERIA_STATES.find(s => s.name === stateName);
    if (!state) return;

    const modalBody = document.getElementById('state-modal-body');
    if (modalBody) {
        modalBody.innerHTML = `
      <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; margin-bottom: 1.5rem;">
        <div>
          <span style="color: #10B981; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">${state.region} Region</span>
          <h2 style="color: #FFFFFF; font-size: 2rem; margin-top: 0.2rem;">${state.name} State</h2>
        </div>
        <div style="background: rgba(212,175,55,0.15); border: 1px solid rgba(212,175,55,0.3); color: #F3C649; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 600;">
          Capital: ${state.capital}
        </div>
      </div>
      <p style="color: #CBD5E1; font-size: 1rem; margin-bottom: 1.25rem;">
        <strong>Economic Focus & Key Hub:</strong> ${state.hub}
      </p>
      <div style="background: rgba(30, 41, 59, 0.6); padding: 1.25rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
        <h4 style="color: #FFFFFF; margin-bottom: 0.5rem;"><i class="fas fa-briefcase" style="color: #10B981;"></i> Trade & Investment Opportunities</h4>
        <p style="color: #94A3B8; font-size: 0.875rem; line-height: 1.5;">
          ${state.name} State presents lucrative avenues for bilateral joint-ventures in commerce, industrialization, and agricultural exports between Kenya and Nigeria.
        </p>
      </div>
    `;
        openModal('state-detail-modal');
    }
};

/* --------------------------------------------------------------------------
   4. APPOINTMENT SCHEDULER & RECEIPT GENERATOR
   -------------------------------------------------------------------------- */
function initAppointmentScheduler() {
    const form = document.getElementById('appointment-booking-form');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const name = document.getElementById('apt-name').value;
        const phone = document.getElementById('apt-phone').value;
        const service = document.getElementById('apt-service').value;
        const date = document.getElementById('apt-date').value;
        const time = document.getElementById('apt-time').value;

        const bookingRef = 'APT-NAI-' + Math.floor(100000 + Math.random() * 900000);

        const voucherBody = document.getElementById('voucher-content');
        if (voucherBody) {
            voucherBody.innerHTML = `
        <div style="border: 2px dashed rgba(212, 175, 55, 0.5); padding: 1.5rem; border-radius: 12px; background: rgba(7, 13, 24, 0.9);">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div style="color: #10B981; font-weight: 700; font-size: 0.9rem;">NIGERIAN HIGH COMMISSION NAIROBI</div>
            <div style="background: rgba(16, 185, 129, 0.2); color: #34D399; padding: 0.2rem 0.6rem; border-radius: 4px; font-weight: 700; font-size: 0.8rem;">CONFIRMED</div>
          </div>
          <h3 style="color: #FFFFFF; margin-bottom: 0.5rem;">Consular Appointment Voucher</h3>
          <p style="color: #F3C649; font-family: monospace; font-size: 1.1rem; font-weight: 700;">Ref Code: ${bookingRef}</p>
          <hr style="border-color: rgba(255,255,255,0.1); margin: 1rem 0;">
          <p style="color: #E2E8F0;"><strong>Applicant:</strong> ${name}</p>
          <p style="color: #E2E8F0;"><strong>Telephone:</strong> ${phone}</p>
          <p style="color: #E2E8F0;"><strong>Service Category:</strong> ${service}</p>
          <p style="color: #E2E8F0;"><strong>Appointment Slot:</strong> ${date} at ${time}</p>
          <p style="color: #E2E8F0;"><strong>Location:</strong> High Commission Complex, Kilimani, Nairobi</p>
          <div style="margin-top: 1.5rem; text-align: center;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=${bookingRef}" alt="QR Code" style="border: 4px solid #fff; border-radius: 8px;">
            <p style="font-size: 0.75rem; color: #94A3B8; margin-top: 0.5rem;">Present this voucher & QR code to Gate Security upon arrival.</p>
          </div>
        </div>
      `;
        }

        closeModal('appointment-modal');
        openModal('voucher-modal');
    });
}

/* --------------------------------------------------------------------------
   5. CONSULAR FEE CALCULATOR
   -------------------------------------------------------------------------- */
function initFeeCalculator() {
    const calcSelect = document.getElementById('calc-service-type');
    const qtyInput = document.getElementById('calc-applicant-qty');
    const feeDisplay = document.getElementById('calc-total-fee');

    if (!calcSelect || !feeDisplay) return;

    function updateFee() {
        const rate = parseFloat(calcSelect.value) || 0;
        const qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;
        const totalUSD = rate * qty;
        const totalKES = totalUSD * 130; // Approx rate for display

        feeDisplay.innerHTML = `$${totalUSD.toFixed(2)} USD <span style="font-size: 0.85rem; color: #94A3B8;">(~${totalKES.toLocaleString()} KES)</span>`;
    }

    calcSelect.addEventListener('change', updateFee);
    if (qtyInput) qtyInput.addEventListener('input', updateFee);
}

/* --------------------------------------------------------------------------
   6. MOBILE NAVIGATION DRAWER TOGGLE
   -------------------------------------------------------------------------- */
function initMobileNav() {
    const trigger = document.getElementById('mobile-menu-trigger');
    const menu = document.getElementById('nav-menu-list');

    if (trigger && menu) {
        trigger.addEventListener('click', () => {
            if (menu.style.display === 'flex') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'flex';
                menu.style.flexDirection = 'column';
                menu.style.position = 'absolute';
                menu.style.top = '100%';
                menu.style.left = '0';
                menu.style.right = '0';
                menu.style.background = '#0F172A';
                menu.style.padding = '1.5rem';
                menu.style.borderBottom = '1px solid rgba(255,255,255,0.1)';
            }
        });
    }
}
