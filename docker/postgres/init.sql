CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) CHECK (role IN ('admin', 'manager', 'developer', 'tester', 'analyst', 'designer')) DEFAULT 'user',
    phone VARCHAR(20),
    address VARCHAR(255),
    position VARCHAR(50),
    department VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    manager_id INT NOT NULL,
    status VARCHAR(20) CHECK (status IN ('Pending', 'Active', 'Completed', 'On Hold')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description TEXT,
    FOREIGN KEY (manager_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE project_team (
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    role VARCHAR(20),
    PRIMARY KEY (project_id, user_id),
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tasks (
    id SERIAL PRIMARY KEY,
    project_id INT NOT NULL,
    description TEXT NOT NULL,
    assigned_to INT,
    status VARCHAR(20) CHECK (status IN ('Pending', 'In Progress', 'Completed')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO users (name, email, password, role, phone, address, position, department) VALUES
('Maciej Malina', 'maciej.malina@gmail.com', 'password1', 'admin', '+48 996 202 101', 'Krakow, Poland', 'CEO', 'CEO'),
('John Smith', 'john.smith@example.com', 'password2', 'manager', '+48 600 700 800', 'Warsaw, Poland', 'Project Manager', 'IT'),
('Jane Doe', 'jane.doe@example.com', 'password3', 'manager', '+48 600 111 222', 'Krakow, Poland', 'Project Manager', 'IT'),
('Emily Johnson', 'emily.johnson@example.com', 'password4', 'developer', '+48 600 333 444', 'Gdansk, Poland', 'Frontend Developer', 'IT'),
('Michael Brown', 'michael.brown@example.com', 'password5', 'developer', '+48 600 555 666', 'Poznan, Poland', 'Backend Developer', 'IT'),
('Olivia Green', 'olivia.green@example.com', 'password6', 'tester', '+48 600 777 888', 'Wroclaw, Poland', 'QA Tester', 'Quality Assurance'),
('James White', 'james.white@example.com', 'password7', 'analyst', '+48 600 999 000', 'Lodz, Poland', 'Business Analyst', 'Business'),
('Sophia Black', 'sophia.black@example.com', 'password8', 'designer', '+48 601 222 333', 'Katowice, Poland', 'UI/UX Designer', 'Design');

INSERT INTO projects (name, manager_id, status, description) VALUES
('Project Alpha', 2, 'Active', 'Developing a new web platform for client X.'),
('Project Beta', 3, 'Completed', 'Completed the redesign of the company`s intranet.'),
('Project Gamma', 2, 'Pending', 'Planning phase for a mobile app for internal use.'),
('Project Delta', 3, 'Active', 'Ongoing updates to the CRM system.'),
('Project Omega', 2, 'On Hold', 'Paused development of the e-commerce platform due to budget constraints.');

INSERT INTO project_team (project_id, user_id, role) VALUES
(1, 4, 'developer'),
(1, 5, 'developer'),
(1, 6, 'tester'),
(2, 7, 'analyst'),
(2, 8, 'designer'),
(3, 5, 'developer'),
(3, 6, 'tester'),
(4, 4, 'developer'),
(4, 7, 'analyst'),
(5, 4, 'developer'),
(5, 5, 'developer'),
(5, 8, 'designer');

INSERT INTO tasks (project_id, description, assigned_to, status) VALUES
(1, 'Develop frontend interface for login page', 4, 'In Progress'),
(1, 'Build backend API for authentication', 5, 'Pending'),
(1, 'Write test cases for authentication', 6, 'Pending'),
(2, 'Create wireframes for dashboard', 7, 'Completed'),
(2, 'Analyze business requirements', 6, 'Completed'),
(3, 'Fix bugs in payment integration', 5, 'In Progress'),
(3, 'Design error messages for failed transactions', 7, 'Pending'),
(4, 'Implement user profile feature', 4, 'Pending'),
(4, 'Optimize database queries for project module', 5, 'Pending'),
(5, 'Redesign homepage UI', 8, 'In Progress'),
(5, 'Write unit tests for project module', 6, 'Pending');


CREATE VIEW project_details AS
SELECT p.id, p.name, u.name AS manager, p.status, COUNT(pt.user_id) AS team_size
FROM projects p
JOIN users u ON p.manager_id = u.id
LEFT JOIN project_team pt ON p.id = pt.project_id
GROUP BY p.id, p.name, u.name, p.status;

CREATE VIEW task_details AS
SELECT t.id, t.description, t.status, u.name AS assigned_user, p.name AS project
FROM tasks t
JOIN projects p ON t.project_id = p.id
LEFT JOIN users u ON t.assigned_to = u.id;

CREATE OR REPLACE FUNCTION activate_project_on_task_insert() RETURNS TRIGGER AS $$
BEGIN
    UPDATE projects SET status = 'Active'
    WHERE id = NEW.project_id AND status = 'Pending';
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_activate_project
AFTER INSERT ON tasks
FOR EACH ROW
EXECUTE FUNCTION activate_project_on_task_insert();

CREATE OR REPLACE FUNCTION count_projects_by_manager(manager_id INT) RETURNS INT AS $$
DECLARE 
    project_count INT;
BEGIN
    SELECT COUNT(*) INTO project_count FROM projects WHERE manager_id = manager_id;
    RETURN project_count;
END;
$$ LANGUAGE plpgsql;

BEGIN;

INSERT INTO projects (name, manager_id, status, description)
VALUES ('New Project', 2, 'Pending', 'Testing transactions')
RETURNING id INTO project_id;

INSERT INTO project_team (project_id, user_id, role)
VALUES (project_id, 4, 'developer');

INSERT INTO project_team (project_id, user_id, role)
VALUES (project_id, 5, 'tester');

COMMIT;