<?php
// index.php
require_once 'config.php';

// Получаем все заметки
$stmt = $pdo->query("SELECT * FROM notes ORDER BY is_favorite DESC, updated_at DESC");
$notes = $stmt->fetchAll();

// Получаем уникальные категории
$stmt = $pdo->query("SELECT DISTINCT category FROM notes WHERE category IS NOT NULL AND category != ''");
$categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Получаем популярные теги
$all_tags = [];
foreach ($notes as $note) {
    if (!empty($note['tags'])) {
        $tags = explode(',', $note['tags']);
        $all_tags = array_merge($all_tags, $tags);
    }
}
$popular_tags = array_count_values($all_tags);
arsort($popular_tags);
$popular_tags = array_slice(array_keys($popular_tags), 0, 10);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн записная книжка</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <!-- Шапка -->
    <header class="header">
        <div class="logo">
            <i class="fas fa-book"></i>
            <h1>Моя записная книжка</h1>
        </div>
        <div class="user-info">
            <button id="addNoteBtn" class="btn btn-primary">
                <i class="fas fa-plus"></i> Новая заметка
            </button>
            <div class="stats">
                <span><i class="fas fa-sticky-note"></i> <?php echo count($notes); ?> заметок</span>
            </div>
        </div>
    </header>

    <div class="main-content">
        <!-- Боковая панель -->
        <aside class="sidebar">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Поиск заметок...">
                <i class="fas fa-search"></i>
            </div>

            <div class="filter-section">
                <h3><i class="fas fa-filter"></i> Фильтры</h3>
                <div class="filter-options">
                    <button class="filter-btn active" data-filter="all">
                        <i class="fas fa-list"></i> Все заметки
                    </button>
                    <button class="filter-btn" data-filter="favorite">
                        <i class="fas fa-star"></i> Избранное
                    </button>
                    <button class="filter-btn" data-filter="recent">
                        <i class="fas fa-clock"></i> Недавние
                    </button>
                </div>
            </div>

            <div class="categories-section">
                <h3><i class="fas fa-folder"></i> Категории</h3>
                <div class="categories-list">
                    <button class="category-btn active" data-category="all">
                        Все категории <span><?php echo count($notes); ?></span>
                    </button>
                    <?php foreach ($categories as $category): ?>
                        <?php
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM notes WHERE category = ?");
                        $stmt->execute([$category]);
                        $count = $stmt->fetchColumn();
                        ?>
                        <button class="category-btn" data-category="<?php echo escape($category); ?>">
                            <?php echo escape($category); ?> <span><?php echo $count; ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="tags-section">
                <h3><i class="fas fa-tags"></i> Популярные теги</h3>
                <div class="tags-list">
                    <?php foreach ($popular_tags as $tag): ?>
                        <span class="tag" data-tag="<?php echo trim(escape($tag)); ?>">
                                <?php echo trim(escape($tag)); ?>
                            </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>

        <!-- Основное содержимое -->
        <main class="notes-container">
            <div class="notes-header">
                <h2 id="notesTitle">Все заметки</h2>
                <div class="view-options">
                    <button class="view-btn active" data-view="grid">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button class="view-btn" data-view="list">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>

            <div class="notes-grid" id="notesGrid">
                <?php if (empty($notes)): ?>
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list fa-3x"></i>
                        <h3>Заметок пока нет</h3>
                        <p>Создайте свою первую заметку!</p>
                        <button id="addFirstNoteBtn" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Создать заметку
                        </button>
                    </div>
                <?php else: ?>
                    <?php foreach ($notes as $note): ?>
                        <div class="note-card"
                             data-id="<?php echo $note['id']; ?>"
                             data-category="<?php echo escape($note['category'] ?? ''); ?>"
                             data-tags="<?php echo escape($note['tags'] ?? ''); ?>"
                             data-favorite="<?php echo $note['is_favorite']; ?>"
                             style="background-color: <?php echo escape($note['color']); ?>">
                            <div class="note-header">
                                <h3 class="note-title"><?php echo escape($note['title']); ?></h3>
                                <div class="note-actions">
                                    <button class="action-btn favorite-btn <?php echo $note['is_favorite'] ? 'favorited' : ''; ?>"
                                            data-id="<?php echo $note['id']; ?>">
                                        <i class="fas fa-star"></i>
                                    </button>
                                    <button class="action-btn edit-btn" data-id="<?php echo $note['id']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn delete-btn" data-id="<?php echo $note['id']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="note-content">
                                <?php echo nl2br(escape(substr($note['content'], 0, 200))); ?>
                                <?php if (strlen($note['content']) > 200): ?>
                                    <span class="read-more">...</span>
                                <?php endif; ?>
                            </div>

                            <div class="note-footer">
                                <div class="note-meta">
                                    <?php if (!empty($note['category'])): ?>
                                        <span class="note-category">
                                                <i class="fas fa-folder"></i> <?php echo escape($note['category']); ?>
                                            </span>
                                    <?php endif; ?>

                                    <span class="note-date">
                                            <i class="far fa-clock"></i> 
                                            <?php echo date('d.m.Y H:i', strtotime($note['updated_at'])); ?>
                                        </span>
                                </div>

                                <?php if (!empty($note['tags'])): ?>
                                    <div class="note-tags">
                                        <?php
                                        $tags = explode(',', $note['tags']);
                                        foreach ($tags as $tag):
                                            $tag = trim($tag);
                                            if (!empty($tag)):
                                                ?>
                                                <span class="note-tag"><?php echo escape($tag); ?></span>
                                            <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<!-- Модальное окно для создания/редактирования заметки -->
<div id="noteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Новая заметка</h2>
            <button class="close-modal">&times;</button>
        </div>

        <form id="noteForm">
            <input type="hidden" id="noteId">

            <div class="form-group">
                <label for="noteTitle">Заголовок</label>
                <input type="text" id="noteTitle" name="title" required maxlength="255" placeholder="Введите заголовок заметки">
            </div>

            <div class="form-group">
                <label for="noteContent">Содержимое</label>
                <textarea id="noteContent" name="content" rows="10" required placeholder="Введите текст заметки..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="noteCategory">Категория</label>
                    <input type="text" id="noteCategory" name="category" list="categoriesList" placeholder="Выберите или введите категорию">
                    <datalist id="categoriesList">
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo escape($category); ?>">
                            <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-group">
                    <label for="noteTags">Теги (через запятую)</label>
                    <input type="text" id="noteTags" name="tags" placeholder="работа, важное, идеи">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="noteColor">Цвет заметки</label>
                    <div class="color-picker">
                        <input type="color" id="noteColor" name="color" value="#ffffff">
                        <div class="color-presets">
                            <div class="color-preset" style="background-color: #ffffff" data-color="#ffffff"></div>
                            <div class="color-preset" style="background-color: #e3f2fd" data-color="#e3f2fd"></div>
                            <div class="color-preset" style="background-color: #f3e5f5" data-color="#f3e5f5"></div>
                            <div class="color-preset" style="background-color: #e8f5e9" data-color="#e8f5e9"></div>
                            <div class="color-preset" style="background-color: #fff3e0" data-color="#fff3e0"></div>
                            <div class="color-preset" style="background-color: #ffebee" data-color="#ffebee"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="noteFavorite" name="is_favorite">
                        <label for="noteFavorite">Добавить в избранное</label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary close-modal">Отмена</button>
                <button type="submit" class="btn btn-primary" id="saveNoteBtn">Сохранить заметку</button>
            </div>
        </form>
    </div>
</div>

<!-- Подключение jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Подключение нашего JS файла -->
<script src="js/script.js"></script>
</body>
</html>