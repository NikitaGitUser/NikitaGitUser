CREATE DATABASE IF NOT EXISTS notebook_app;
USE notebook_app;

CREATE TABLE IF NOT EXISTS notes (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(100),
    tags VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_favorite BOOLEAN DEFAULT FALSE,
    color VARCHAR(20) DEFAULT '#ffffff'
    );

-- Вставка тестовых записей
INSERT INTO notes (title, content, category, tags, is_favorite, color) VALUES
                                                                           ('План на неделю', '1. Закончить проект\n2. Записаться к врачу\n3. Встреча с командой в пятницу', 'Планы', 'работа, здоровье', FALSE, '#e3f2fd'),
                                                                           ('Идеи для отпуска', 'Посетить:\n- Горный курорт\n- Исторический музей\n- Местный ресторан с национальной кухней', 'Путешествия', 'отпуск, планы', TRUE, '#f3e5f5'),
                                                                           ('Рецепт борща', 'Ингредиенты:\n- Свекла 2 шт\n- Мясо 500г\n- Капуста 300г\n- Сметана для подачи\n\nПриготовление:...', 'Рецепты', 'еда, кулинария', FALSE, '#e8f5e9'),
                                                                           ('Финансовые цели', '1. Накопить на отпуск - 50,000 руб\n2. Погасить кредит до конца года\n3. Инвестировать 10% от дохода', 'Финансы', 'деньги, цели', TRUE, '#fff3e0');