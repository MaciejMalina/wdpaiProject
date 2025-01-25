-- Przykładowi użytkownicy
INSERT INTO users (name, email, password, role) VALUES
('Maciej Malina', 'maciej.malina@gmail.com', '$password1', 'admin'),
('Jan Kowalski', 'jan.kowalski@gmail.com', 'password2', 'user');

-- Przykładowe projekty
INSERT INTO projects (name, manager_id, status, team) VALUES
('Website Redesign', 1, 'In Progress', '["Developer 1", "Designer 1"]'),
('Mobile App', 2, 'Pending', '["Tester 1", "Developer 2"]');

-- Przykładowe zadania
INSERT INTO tasks (project_id, description, assigned_to, status) VALUES
(1, 'Create wireframes for homepage', 1, 'Completed'),
(1, 'Develop login functionality', 2, 'In Progress'),
(2, 'Set up database schema', NULL, 'Pending');
