<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Notice {
    public static function getPublished(int $limit = 10): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM notices WHERE is_published = 1 ORDER BY is_urgent DESC, published_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT n.*, u.full_name as author_name FROM notices n LEFT JOIN users u ON n.author_id = u.id ORDER BY n.created_at DESC");
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM notices WHERE slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        $notice = $stmt->fetch();
        return $notice ?: null;
    }

    public static function find(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM notices WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $notice = $stmt->fetch();
        return $notice ?: null;
    }

    public static function create(array $data): int {
        $db = Database::getConnection();
        $slug = preg_replace('/[^a-z0-9-]+/', '-', strtolower($data['title'])) . '-' . rand(100, 999);
        $stmt = $db->prepare("INSERT INTO notices (title, slug, category, content, featured_image, is_urgent, is_published, author_id) VALUES (:title, :slug, :category, :content, :featured_image, :is_urgent, :is_published, :author_id)");
        $stmt->execute([
            ':title' => $data['title'],
            ':slug' => $slug,
            ':category' => $data['category'],
            ':content' => $data['content'],
            ':featured_image' => $data['featured_image'] ?? null,
            ':is_urgent' => !empty($data['is_urgent']) ? 1 : 0,
            ':is_published' => !empty($data['is_published']) ? 1 : 0,
            ':author_id' => $data['author_id'] ?? null
        ]);
        return (int)$db->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        $db = Database::getConnection();
        $fields = [
            'title = :title',
            'category = :category',
            'content = :content',
            'is_urgent = :is_urgent',
            'is_published = :is_published'
        ];
        $params = [
            ':id' => $id,
            ':title' => $data['title'],
            ':category' => $data['category'],
            ':content' => $data['content'],
            ':is_urgent' => !empty($data['is_urgent']) ? 1 : 0,
            ':is_published' => !empty($data['is_published']) ? 1 : 0
        ];

        if (array_key_exists('featured_image', $data)) {
            $fields[] = 'featured_image = :featured_image';
            $params[':featured_image'] = $data['featured_image'];
        }

        $sql = "UPDATE notices SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM notices WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
