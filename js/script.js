// js/script.js
$(document).ready(function() {
    // Инициализация
    initFilters();
    initViewToggle();
    initModal();
    initActions();

    // Поиск с задержкой
    let searchTimeout;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadNotes();
        }, 300);
    });

    // Загрузка заметок при изменении фильтров
    $('.filter-btn, .category-btn').on('click', function() {
        loadNotes();
    });

    // Клик по тегу
    $('.tags-list').on('click', '.tag', function() {
        const tag = $(this).data('tag');
        $('#searchInput').val(tag);
        loadNotes();
    });

    // Создание первой заметки
    $('#addFirstNoteBtn').click(function() {
        showModal();
    });
});

// Инициализация фильтров
function initFilters() {
    $('.filter-btn').click(function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
    });

    $('.category-btn').click(function() {
        $('.category-btn').removeClass('active');
        $(this).addClass('active');
    });
}

// Переключение вида
function initViewToggle() {
    $('.view-btn').click(function() {
        $('.view-btn').removeClass('active');
        $(this).addClass('active');

        const view = $(this).data('view');
        if (view === 'list') {
            $('#notesGrid').addClass('list-view');
        } else {
            $('#notesGrid').removeClass('list-view');
        }
    });
}

// Модальное окно
function initModal() {
    const $modal = $('#noteModal');

    // Открытие модального окна для создания
    $('#addNoteBtn, #addFirstNoteBtn').click(function() {
        resetForm();
        $('#modalTitle').text('Новая заметка');
        $modal.addClass('active');
    });

    // Закрытие модального окна
    $('.close-modal').click(function() {
        $modal.removeClass('active');
    });

    // Клик вне модального окна
    $(window).click(function(event) {
        if ($(event.target).is($modal)) {
            $modal.removeClass('active');
        }
    });

    // Сохранение заметки
    $('#noteForm').submit(function(e) {
        e.preventDefault();
        saveNote();
    });

    // Предустановленные цвета
    $('.color-preset').click(function() {
        const color = $(this).data('color');
        $('#noteColor').val(color);
    });
}

// Действия с заметками
function initActions() {
    // Редактирование заметки
    $(document).on('click', '.edit-btn', function() {
        const noteId = $(this).data('id');
        loadNoteForEdit(noteId);
    });

    // Удаление заметки
    $(document).on('click', '.delete-btn', function() {
        const noteId = $(this).data('id');
        if (confirm('Вы уверены, что хотите удалить эту заметку?')) {
            deleteNote(noteId);
        }
    });

    // Добавление в избранное
    $(document).on('click', '.favorite-btn', function(e) {
        e.stopPropagation();
        const noteId = $(this).data('id');
        const isFavorite = !$(this).hasClass('favorited');
        toggleFavorite(noteId, isFavorite);
    });
}

// Сброс формы
function resetForm() {
    $('#noteForm')[0].reset();
    $('#noteId').val('');
    $('#noteColor').val('#ffffff');
    $('#noteFavorite').prop('checked', false);
}

// Загрузка заметки для редактирования
function loadNoteForEdit(noteId) {
    $.ajax({
        url: 'ajax.php?id=' + noteId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const note = response.note;
                $('#noteId').val(note.id);
                $('#noteTitle').val(note.title);
                $('#noteContent').val(note.content);
                $('#noteCategory').val(note.category || '');
                $('#noteTags').val(note.tags || '');
                $('#noteColor').val(note.color);
                $('#noteFavorite').prop('checked', note.is_favorite == 1);

                $('#modalTitle').text('Редактировать заметку');
                $('#noteModal').addClass('active');
            } else {
                alert('Ошибка загрузки заметки: ' + response.error);
            }
        },
        error: function() {
            alert('Ошибка соединения с сервером');
        }
    });
}

// Сохранение заметки
function saveNote() {
    const noteId = $('#noteId').val();
    const method = noteId ? 'PUT' : 'POST';
    const url = 'ajax.php';

    const data = {
        title: $('#noteTitle').val(),
        content: $('#noteContent').val(),
        category: $('#noteCategory').val(),
        tags: $('#noteTags').val(),
        color: $('#noteColor').val(),
        is_favorite: $('#noteFavorite').is(':checked')
    };

    if (noteId) {
        data.id = noteId;
    }

    $('#saveNoteBtn').prop('disabled', true).text('Сохранение...');

    $.ajax({
        url: url,
        method: method,
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: 'json',
        success: function(response) {
            $('#saveNoteBtn').prop('disabled', false).text('Сохранить заметку');

            if (response.success) {
                $('#noteModal').removeClass('active');
                loadNotes();

                // Обновляем статистику
                updateStats();
            } else {
                alert('Ошибка сохранения: ' + response.error);
            }
        },
        error: function() {
            $('#saveNoteBtn').prop('disabled', false).text('Сохранить заметку');
            alert('Ошибка соединения с сервером');
        }
    });
}

// Удаление заметки
function deleteNote(noteId) {
    $.ajax({
        url: 'ajax.php',
        method: 'DELETE',
        contentType: 'application/json',
        data: JSON.stringify({ id: noteId }),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                loadNotes();
                updateStats();
            } else {
                alert('Ошибка удаления: ' + response.error);
            }
        },
        error: function() {
            alert('Ошибка соединения с сервером');
        }
    });
}

// Изменение статуса избранного
function toggleFavorite(noteId, isFavorite) {
    $.ajax({
        url: 'ajax.php',
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify({
            id: noteId,
            is_favorite: isFavorite,
            // Сохраняем остальные поля
            title: $('#noteTitle').val() || '',
            content: $('#noteContent').val() || '',
            category: $('#noteCategory').val() || '',
            tags: $('#noteTags').val() || '',
            color: $('#noteColor').val() || '#ffffff'
        }),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                loadNotes();
            } else {
                alert('Ошибка обновления: ' + response.error);
            }
        },
        error: function() {
            alert('Ошибка соединения с сервером');
        }
    });
}

// Загрузка заметок с фильтрами
function loadNotes() {
    const search = $('#searchInput').val();
    const activeFilter = $('.filter-btn.active').data('filter');
    const activeCategory = $('.category-btn.active').data('category');

    let url = 'ajax.php?';
    const params = [];

    if (search) params.push('search=' + encodeURIComponent(search));
    if (activeFilter !== 'all') params.push('filter=' + activeFilter);
    if (activeCategory !== 'all') params.push('category=' + encodeURIComponent(activeCategory));
    if (activeFilter === 'favorite') params.push('favorite=true');

    url += params.join('&');

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                renderNotes(response.notes);
                updateTitle(response.notes.length);
            } else {
                alert('Ошибка загрузки заметок: ' + response.error);
            }
        },
        error: function() {
            alert('Ошибка соединения с сервером');
        }
    });
}

// Отображение заметок
function renderNotes(notes) {
    if (notes.length === 0) {
        $('#notesGrid').html(`
            <div class="empty-state">
                <i class="fas fa-clipboard-list fa-3x"></i>
                <h3>Заметок не найдено</h3>
                <p>Попробуйте изменить параметры поиска</p>
                <button id="addFirstNoteBtn" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Создать заметку
                </button>
            </div>
        `);
        return;
    }

    let html = '';
    notes.forEach(note => {
        const tags = note.tags ? note.tags.split(',').map(tag => tag.trim()) : [];
        const isFavorite = note.is_favorite == 1;
        const date = new Date(note.updated_at).toLocaleDateString('ru-RU', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        let tagsHtml = '';
        if (tags.length > 0) {
            tagsHtml = '<div class="note-tags">';
            tags.forEach(tag => {
                if (tag) {
                    tagsHtml += `<span class="note-tag">${escapeHtml(tag)}</span>`;
                }
            });
            tagsHtml += '</div>';
        }

        html += `
        <div class="note-card" 
             data-id="${note.id}"
             data-category="${escapeHtml(note.category || '')}"
             data-tags="${escapeHtml(note.tags || '')}"
             data-favorite="${isFavorite}"
             style="background-color: ${note.color}">
            <div class="note-header">
                <h3 class="note-title">${escapeHtml(note.title)}</h3>
                <div class="note-actions">
                    <button class="action-btn favorite-btn ${isFavorite ? 'favorited' : ''}"
                            data-id="${note.id}">
                        <i class="fas fa-star"></i>
                    </button>
                    <button class="action-btn edit-btn" data-id="${note.id}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn delete-btn" data-id="${note.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <div class="note-content">
                ${escapeHtml(note.content).substring(0, 200).replace(/\n/g, '<br>')}
                ${note.content.length > 200 ? '<span class="read-more">...</span>' : ''}
            </div>
            
            <div class="note-footer">
                <div class="note-meta">
                    ${note.category ? `
                    <span class="note-category">
                        <i class="fas fa-folder"></i> ${escapeHtml(note.category)}
                    </span>` : ''}
                    
                    <span class="note-date">
                        <i class="far fa-clock"></i> ${date}
                    </span>
                </div>
                
                ${tagsHtml}
            </div>
        </div>
        `;
    });

    $('#notesGrid').html(html);
}

// Обновление заголовка
function updateTitle(count) {
    let title = 'Все заметки';
    const activeFilter = $('.filter-btn.active').data('filter');
    const activeCategory = $('.category-btn.active').data('category');

    if (activeFilter === 'favorite') title = 'Избранное';
    if (activeFilter === 'recent') title = 'Недавние';
    if (activeCategory !== 'all') title = activeCategory;

    $('#notesTitle').text(`${title} (${count})`);
}

// Обновление статистики
function updateStats() {
    $.ajax({
        url: 'ajax.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('.stats span').html(`<i class="fas fa-sticky-note"></i> ${response.notes.length} заметок`);
            }
        }
    });
}

// Экранирование HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Показать модальное окно (для использования из других частей кода)
function showModal() {
    resetForm();
    $('#modalTitle').text('Новая заметка');
    $('#noteModal').addClass('active');
}