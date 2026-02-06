<?php
// ajax.php
require_once 'config.php';

header('Content-Type: application/json');

// Получаем метод запроса
$method = $_SERVER['REQUEST_METHOD'];

// Обработка разных методов
switch($method) {
    case 'GET':
        handleGet();
        break;
    case 'POST':
        handlePost();
        break;
    case 'PUT':
        handlePut();
        break;
    case 'DELETE':
        handleDelete();
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Метод не поддерживается']);
}

function handleGet() {
    global $pdo;

    // Получить конкретную заметку по ID
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $note = $stmt->fetch();

        if ($note) {
            echo json_encode(['success' => true, 'note' => $note]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Заметка не найдена']);
        }
        return;
    }

    // Поиск заметок
    $where = [];
    $params = [];

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = '%' . $_GET['search'] . '%';
        $where[] = "(title LIKE ? OR content LIKE ? OR tags LIKE ?)";
        $params = array_merge($params, [$search, $search, $search]);
    }

    if (isset($_GET['category']) && $_GET['category'] !== 'all') {
        $where[] = "category = ?";
        $params[] = $_GET['category'];
    }

    if (isset($_GET['tag']) && !empty($_GET['tag'])) {
        $where[] = "tags LIKE ?";
        $params[] = '%' . $_GET['tag'] . '%';
    }

    if (isset($_GET['favorite']) && $_GET['favorite'] === 'true') {
        $where[] = "is_favorite = 1";
    }

    $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    $stmt = $pdo->prepare("SELECT * FROM notes $whereClause ORDER BY is_favorite DESC, updated_at DESC");
    $stmt->execute($params);
    $notes = $stmt->fetchAll();

    echo json_encode(['success' => true, 'notes' => $notes]);
}

function handlePost() {
    global $pdo;

    $data = json_decode(file_get_contents('php://input'), true);

    // Валидация
    if (empty($data['title']) || empty($data['content'])) {
        echo json_encode(['success' => false, 'error' => 'Заголовок и содержимое обязательны']);
        return;
    }

    // Создание новой заметки
    $stmt = $pdo->prepare("
        INSERT INTO notes (title, content, category, tags, is_favorite, color) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    try {
        $stmt->execute([
            $data['title'],
            $data['content'],
            $data['category'] ?? null,
            $data['tags'] ?? null,
            $data['is_favorite'] ? 1 : 0,
            $data['color'] ?? '#ffffff'
        ]);

        $noteId = $pdo->lastInsertId();

        // Получить созданную заметку
        $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
        $stmt->execute([$noteId]);
        $note = $stmt->fetch();

        echo json_encode(['success' => true, 'note' => $note]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Ошибка сохранения: ' . $e->getMessage()]);
    }
}

function handlePut() {
    global $pdo;

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id'])) {
        echo json_encode(['success' => false, 'error' => 'ID заметки обязателен']);
        return;
    }

    // Обновление заметки
    $stmt = $pdo->prepare("
        UPDATE notes 
        SET title = ?, content = ?, category = ?, tags = ?, is_favorite = ?, color = ?, updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
    ");

    try {
        $stmt->execute([
            $data['title'],
            $data['content'],
            $data['category'] ?? null,
            $data['tags'] ?? null,
            $data['is_favorite'] ? 1 : 0,
            $data['color'] ?? '#ffffff',
            $data['id']
        ]);

        if ($stmt->rowCount() > 0) {
            // Получить обновленную заметку
            $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
            $stmt->execute([$data['id']]);
            $note = $stmt->fetch();

            echo json_encode(['success' => true, 'note' => $note]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Заметка не найдена']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Ошибка обновления: ' . $e->getMessage()]);
    }
}

function handleDelete() {
    global $pdo;

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id'])) {
        echo json_encode(['success' => false, 'error' => 'ID заметки обязателен']);
        return;
    }

    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");

    try {
        $stmt->execute([$data['id']]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Заметка не найдена']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Ошибка удаления: ' . $e->getMessage()]);
    }
}
?>