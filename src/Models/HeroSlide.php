<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class HeroSlide {
    /**
     * Get all enabled published hero slides for public homepage
     */
    public static function getPublishedSlides(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM hero_slides WHERE is_enabled = 1 ORDER BY display_order ASC, id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all hero slides for admin management
     */
    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM hero_slides ORDER BY display_order ASC, id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get slide by ID
     */
    public static function find(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM hero_slides WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $slide = $stmt->fetch(PDO::FETCH_ASSOC);
        return $slide ?: null;
    }

    /**
     * Create new hero slide
     */
    public static function create(array $data): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO hero_slides 
            (heading, subheading, image_desktop, image_mobile, image_alt, cta_primary_label, cta_primary_url, cta_secondary_label, cta_secondary_url, caption_theme, text_align, display_order, is_enabled)
            VALUES (:heading, :subheading, :img_d, :img_m, :alt, :cta_p_lbl, :cta_p_url, :cta_s_lbl, :cta_s_url, :theme, :align, :order, :enabled)
        ");
        $stmt->execute([
            ':heading' => $data['heading'],
            ':subheading' => $data['subheading'] ?? null,
            ':img_d' => $data['image_desktop'],
            ':img_m' => $data['image_mobile'] ?? $data['image_desktop'],
            ':alt' => $data['image_alt'],
            ':cta_p_lbl' => $data['cta_primary_label'] ?? null,
            ':cta_p_url' => $data['cta_primary_url'] ?? null,
            ':cta_s_lbl' => $data['cta_secondary_label'] ?? null,
            ':cta_s_url' => $data['cta_secondary_url'] ?? null,
            ':theme' => $data['caption_theme'] ?? 'light_on_dark',
            ':align' => $data['text_align'] ?? 'left',
            ':order' => (int)($data['display_order'] ?? 0),
            ':enabled' => (int)($data['is_enabled'] ?? 1)
        ]);

        return (int)$db->lastInsertId();
    }

    /**
     * Update existing hero slide
     */
    public static function update(int $id, array $data): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            UPDATE hero_slides 
            SET heading = :heading,
                subheading = :subheading,
                image_desktop = :img_d,
                image_mobile = :img_m,
                image_alt = :alt,
                cta_primary_label = :cta_p_lbl,
                cta_primary_url = :cta_p_url,
                cta_secondary_label = :cta_s_lbl,
                cta_secondary_url = :cta_s_url,
                caption_theme = :theme,
                text_align = :align,
                display_order = :order,
                is_enabled = :enabled
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':heading' => $data['heading'],
            ':subheading' => $data['subheading'] ?? null,
            ':img_d' => $data['image_desktop'],
            ':img_m' => $data['image_mobile'] ?? $data['image_desktop'],
            ':alt' => $data['image_alt'],
            ':cta_p_lbl' => $data['cta_primary_label'] ?? null,
            ':cta_p_url' => $data['cta_primary_url'] ?? null,
            ':cta_s_lbl' => $data['cta_secondary_label'] ?? null,
            ':cta_s_url' => $data['cta_secondary_url'] ?? null,
            ':theme' => $data['caption_theme'] ?? 'light_on_dark',
            ':align' => $data['text_align'] ?? 'left',
            ':order' => (int)($data['display_order'] ?? 0),
            ':enabled' => (int)($data['is_enabled'] ?? 1)
        ]);
    }

    /**
     * Toggle enabled status
     */
    public static function toggle(int $id, int $isEnabled): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE hero_slides SET is_enabled = :e WHERE id = :id");
        return $stmt->execute([':e' => $isEnabled, ':id' => $id]);
    }

    /**
     * Delete slide
     */
    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM hero_slides WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
