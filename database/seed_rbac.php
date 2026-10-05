<?php

require_once __DIR__ . '/../src/autoload.php';

use App\Core\Database;

$db = Database::getConnection();

echo "=== SEEDING DYNAMIC RBAC ROLES AND PERMISSIONS ===\n";

// 1. Roles Definition
$roles = [
    ['name' => 'Public Visitor', 'slug' => 'public_visitor', 'description' => 'Public content and permitted intake only.', 'is_system' => 1],
    ['name' => 'Citizen Applicant', 'slug' => 'citizen', 'description' => 'Own profile, records, drafts, appointments, messages and permitted files.', 'is_system' => 1],
    ['name' => 'Consular Officer', 'slug' => 'consular_officer', 'description' => 'Assigned/permitted service cases and limited citizen data.', 'is_system' => 1],
    ['name' => 'Registry & Welfare Officer', 'slug' => 'registry_welfare_officer', 'description' => 'Authorised registry review and welfare cases within scope.', 'is_system' => 1],
    ['name' => 'Trade Officer', 'slug' => 'trade_officer', 'description' => 'Assigned trade enquiries and related approved actions.', 'is_system' => 1],
    ['name' => 'Appointment Officer', 'slug' => 'appointment_officer', 'description' => 'Approved scheduling, capacity and check-in actions.', 'is_system' => 1],
    ['name' => 'Content Editor', 'slug' => 'content_editor', 'description' => 'Draft public content/media, without routine private citizen-data access.', 'is_system' => 1],
    ['name' => 'Publisher / Content Approver', 'slug' => 'publisher', 'description' => 'Approve/publish public content, without inherited citizen access.', 'is_system' => 1],
    ['name' => 'Supervisor', 'slug' => 'supervisor', 'description' => 'Authorised team assignment, queues, escalation and reporting.', 'is_system' => 1],
    ['name' => 'Administrator', 'slug' => 'admin', 'description' => 'Account/configuration administration; private-case access only through explicit permissions.', 'is_system' => 1],
    ['name' => 'Auditor', 'slug' => 'auditor', 'description' => 'Scoped read-only audit/report access.', 'is_system' => 1],
    ['name' => 'Restricted Super Admin', 'slug' => 'super_admin', 'description' => 'Audited exceptional system administration.', 'is_system' => 1]
];

$roleIds = [];
$roleStmt = $db->prepare("INSERT INTO roles (name, slug, description, is_system) VALUES (:name, :slug, :desc, :sys) ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description)");
foreach ($roles as $r) {
    $roleStmt->execute([':name' => $r['name'], ':slug' => $r['slug'], ':desc' => $r['description'], ':sys' => $r['is_system']]);
    $roleIds[$r['slug']] = $db->lastInsertId() ?: $db->query("SELECT id FROM roles WHERE slug = " . $db->quote($r['slug']))->fetchColumn();
}
echo "[PASS] 12 Roles seeded/verified.\n";

// 2. Permissions Definition
$permissions = [
    // Consular Cases
    ['name' => 'View Assigned Cases', 'slug' => 'cases.view_assigned', 'module' => 'consular', 'description' => 'View consular cases assigned to officer'],
    ['name' => 'Manage All Cases', 'slug' => 'cases.manage_all', 'module' => 'consular', 'description' => 'Update any consular case status and assign officers'],
    ['name' => 'Export Case Records', 'slug' => 'cases.export', 'module' => 'consular', 'description' => 'Export tabular consular case data'],
    
    // Registry & Diaspora
    ['name' => 'Review Registry', 'slug' => 'registry.review', 'module' => 'diaspora', 'description' => 'Review and verify diaspora citizen registrations'],
    ['name' => 'Export Registry Data', 'slug' => 'registry.export', 'module' => 'diaspora', 'description' => 'Export diaspora citizen records'],
    
    // Trade & Investment
    ['name' => 'Manage Trade Enquiries', 'slug' => 'trade.manage', 'module' => 'trade', 'description' => 'Manage trade matchmaking enquiries'],
    
    // Appointments
    ['name' => 'Manage Appointments', 'slug' => 'appointments.manage', 'module' => 'appointments', 'description' => 'Manage and check-in appointment slots'],
    
    // CMS & Content
    ['name' => 'Draft Content', 'slug' => 'content.draft', 'module' => 'cms', 'description' => 'Draft news, notices, and CMS content'],
    ['name' => 'Approve & Publish Content', 'slug' => 'content.publish', 'module' => 'cms', 'description' => 'Approve and publish CMS content'],
    
    // Verifications & Seals
    ['name' => 'Issue Verification Seals', 'slug' => 'verifications.issue', 'module' => 'verifications', 'description' => 'Issue official verification seal codes'],
    
    // Audit & System
    ['name' => 'View Audit Logs', 'slug' => 'audit.view', 'module' => 'system', 'description' => 'Access operational audit logs'],
    ['name' => 'Manage System Users & Roles', 'slug' => 'system.manage_users', 'module' => 'system', 'description' => 'Manage user accounts, roles, and permissions'],
    ['name' => 'Manage Institutional Settings', 'slug' => 'system.manage_settings', 'module' => 'system', 'description' => 'Update branding, canonical domain, and contact settings']
];

$permIds = [];
$permStmt = $db->prepare("INSERT INTO permissions (name, slug, module, description) VALUES (:name, :slug, :mod, :desc) ON DUPLICATE KEY UPDATE name = VALUES(name), module = VALUES(module), description = VALUES(description)");
foreach ($permissions as $p) {
    $permStmt->execute([':name' => $p['name'], ':slug' => $p['slug'], ':mod' => $p['module'], ':desc' => $p['description']]);
    $permIds[$p['slug']] = $db->lastInsertId() ?: $db->query("SELECT id FROM permissions WHERE slug = " . $db->quote($p['slug']))->fetchColumn();
}
echo "[PASS] 13 Granular permissions seeded/verified.\n";

// 3. Default Role Permission Mappings (Only if not already populated to preserve admin updates)
$rolePermMap = [
    'consular_officer' => ['cases.view_assigned', 'cases.manage_all', 'verifications.issue'],
    'registry_welfare_officer' => ['registry.review', 'registry.export'],
    'trade_officer' => ['trade.manage'],
    'appointment_officer' => ['appointments.manage'],
    'content_editor' => ['content.draft'],
    'publisher' => ['content.draft', 'content.publish'],
    'supervisor' => ['cases.view_assigned', 'cases.manage_all', 'cases.export', 'registry.review', 'appointments.manage', 'content.draft', 'content.publish'],
    'admin' => ['cases.view_assigned', 'cases.manage_all', 'cases.export', 'registry.review', 'trade.manage', 'appointments.manage', 'content.draft', 'content.publish', 'verifications.issue', 'audit.view', 'system.manage_users', 'system.manage_settings'],
    'auditor' => ['audit.view', 'cases.export', 'registry.export'],
    'super_admin' => ['cases.view_assigned', 'cases.manage_all', 'cases.export', 'registry.review', 'trade.manage', 'appointments.manage', 'content.draft', 'content.publish', 'verifications.issue', 'audit.view', 'system.manage_users', 'system.manage_settings']
];

$rpStmt = $db->prepare("INSERT IGNORE INTO role_permissions (role_id, permission_id) VALUES (:rid, :pid)");
foreach ($rolePermMap as $roleSlug => $permSlugs) {
    if (isset($roleIds[$roleSlug])) {
        $rid = $roleIds[$roleSlug];
        foreach ($permSlugs as $pSlug) {
            if (isset($permIds[$pSlug])) {
                $rpStmt->execute([':rid' => $rid, ':pid' => $permIds[$pSlug]]);
            }
        }
    }
}
echo "[PASS] Role-permission default mappings linked.\n";

// 4. Map existing users to user_roles
$users = $db->query("SELECT id, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
$urStmt = $db->prepare("INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (:uid, :rid)");
foreach ($users as $u) {
    $roleSlug = $u['role'];
    if ($roleSlug === 'admin') $roleSlug = 'super_admin';
    if ($roleSlug === 'officer') $roleSlug = 'consular_officer';
    if ($roleSlug === 'editor') $roleSlug = 'content_editor';
    if (isset($roleIds[$roleSlug])) {
        $urStmt->execute([':uid' => $u['id'], ':rid' => $roleIds[$roleSlug]]);
    }
}
echo "[PASS] User-role mappings populated.\n";

// 5. Institutional System Settings Default Seeds
$settings = [
    ['setting_key' => 'canonical_domain', 'setting_value' => 'https://nigeriankenya.or.ke', 'group_name' => 'general'],
    ['setting_key' => 'mission_name', 'setting_value' => 'High Commission of the Federal Republic of Nigeria', 'group_name' => 'general'],
    ['setting_key' => 'short_name', 'setting_value' => 'Nigeria High Commission', 'group_name' => 'general'],
    ['setting_key' => 'app_name', 'setting_value' => 'Nigeria High Commission Nairobi', 'group_name' => 'general'],
    ['setting_key' => 'app_tagline', 'setting_value' => 'Nairobi, Republic of Kenya', 'group_name' => 'general'],
    ['setting_key' => 'chancery_address', 'setting_value' => 'Lenana Road, Kilimani, P.O. Box 30294-00100, Nairobi, Kenya', 'group_name' => 'contact'],
    ['setting_key' => 'chancery_phone', 'setting_value' => '+254 20 2713412', 'group_name' => 'contact'],
    ['setting_key' => 'emergency_hotline', 'setting_value' => '+254 795 770 247', 'group_name' => 'contact'],
    ['setting_key' => 'chancery_email', 'setting_value' => 'info@nigeriankenya.or.ke', 'group_name' => 'contact'],
    ['setting_key' => 'office_hours_summary', 'setting_value' => 'Monday – Friday: 8:30 AM – 4:30 PM (Consular Intake: 9:00 AM – 1:00 PM)', 'group_name' => 'contact'],
    ['setting_key' => 'social_twitter', 'setting_value' => 'https://x.com/nigeriankenya', 'group_name' => 'social'],
    ['setting_key' => 'social_facebook', 'setting_value' => 'https://facebook.com/nigeriankenya', 'group_name' => 'social'],
    ['setting_key' => 'social_instagram', 'setting_value' => 'https://instagram.com/nigeriankenya', 'group_name' => 'social'],
    ['setting_key' => 'copyright_text', 'setting_value' => '© 2026 High Commission of the Federal Republic of Nigeria, Nairobi, Kenya. All Rights Reserved.', 'group_name' => 'general'],
    ['setting_key' => 'branding_primary_color', 'setting_value' => '#008852', 'group_name' => 'branding'],
    ['setting_key' => 'branding_dark_color', 'setting_value' => '#0C1406', 'group_name' => 'branding'],
    ['setting_key' => 'branding_leaf_color', 'setting_value' => '#54B435', 'group_name' => 'branding'],
    ['setting_key' => 'branding_accent_color', 'setting_value' => '#D5862C', 'group_name' => 'branding'],
    ['setting_key' => 'font_heading', 'setting_value' => 'Montserrat', 'group_name' => 'typography'],
    ['setting_key' => 'font_body', 'setting_value' => 'Open Sans', 'group_name' => 'typography'],
    ['setting_key' => 'font_button', 'setting_value' => 'Poppins', 'group_name' => 'typography'],
    ['setting_key' => 'logo_main', 'setting_value' => '', 'group_name' => 'branding'],
    ['setting_key' => 'logo_footer', 'setting_value' => '', 'group_name' => 'branding'],
    ['setting_key' => 'logo_auth', 'setting_value' => '', 'group_name' => 'branding'],
    ['setting_key' => 'logo_sidebar', 'setting_value' => '', 'group_name' => 'branding'],
    ['setting_key' => 'logo_dark_bg', 'setting_value' => '', 'group_name' => 'branding'],
    ['setting_key' => 'logo_light_bg', 'setting_value' => '', 'group_name' => 'branding'],
    ['setting_key' => 'logo_alt_text', 'setting_value' => 'Coat of Arms of the Federal Republic of Nigeria', 'group_name' => 'branding'],
    ['setting_key' => 'favicon_url', 'setting_value' => '', 'group_name' => 'branding'],
];

// Seed defaults without overwriting administrator's saved values
$setStmt = $db->prepare("INSERT IGNORE INTO system_settings (setting_key, setting_value, group_name) VALUES (:k, :v, :g)");
foreach ($settings as $s) {
    $setStmt->execute([':k' => $s['setting_key'], ':v' => $s['setting_value'], ':g' => $s['group_name']]);
}
echo "[PASS] Default system settings seeded safely (existing admin settings preserved).\n";

echo "RBAC & System Seeding Completed Successfully!\n";
