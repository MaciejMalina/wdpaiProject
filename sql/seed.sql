-- Przykładowi użytkownicy
INSERT INTO users (name, email, password, role, phone, address, position, department) VALUES
('Maciej Malina', 'maciej.malina@gmail.com', '$password1', 'admin', '+48 996 202 101', 'Krakow, Poland', 'CEO', 'CEO'),
('John Smith', 'john.smith@example.com', 'password123', 'manager', '+48 600 700 800', 'Warsaw, Poland', 'Project Manager', 'IT'),
('Jane Doe', 'jane.doe@example.com', 'password123', 'manager', '+48 600 111 222', 'Krakow, Poland', 'Project Manager', 'IT'),
('Emily Johnson', 'emily.johnson@example.com', 'password123', 'developer', '+48 600 333 444', 'Gdansk, Poland', 'Frontend Developer', 'IT'),
('Michael Brown', 'michael.brown@example.com', 'password123', 'developer', '+48 600 555 666', 'Poznan, Poland', 'Backend Developer', 'IT'),
('Olivia Green', 'olivia.green@example.com', 'password123', 'tester', '+48 600 777 888', 'Wroclaw, Poland', 'QA Tester', 'Quality Assurance'),
('James White', 'james.white@example.com', 'password123', 'analyst', '+48 600 999 000', 'Lodz, Poland', 'Business Analyst', 'Business'),
('Sophia Black', 'sophia.black@example.com', 'password123', 'designer', '+48 601 222 333', 'Katowice, Poland', 'UI/UX Designer', 'Design');

-- Przykładowe projekty
INSERT INTO projects (name, manager_id, status, team) VALUES
('Project Alpha', 1, 'Active', 'Emily Johnson, Michael Brown, Olivia Green'),
('Project Beta', 2, 'Completed', 'Sophia Black, James White'),
('Project Gamma', 1, 'Pending', 'Michael Brown, Olivia Green'),
('Project Delta', 2, 'Active', 'Emily Johnson, James White'),
('Project Omega', 1, 'On Hold', 'Sophia Black, Emily Johnson, Michael Brown');

-- Przykładowe zadania
INSERT INTO tasks (project_id, description, assigned_to, status) VALUES
(1, 'Develop frontend interface for login page', 3, 'In Progress'),
(1, 'Build backend API for authentication', 4, 'Pending'),
(1, 'Write test cases for authentication', 5, 'Pending'),
(2, 'Create wireframes for dashboard', 7, 'Completed'),
(2, 'Analyze business requirements', 6, 'Completed'),
(3, 'Fix bugs in payment integration', 4, 'In Progress'),
(3, 'Design error messages for failed transactions', 7, 'Pending'),
(4, 'Implement user profile feature', 3, 'Pending'),
(4, 'Optimize database queries for project module', 4, 'Pending'),
(5, 'Redesign homepage UI', 7, 'In Progress'),
(5, 'Write unit tests for project module', 5, 'Pending');
