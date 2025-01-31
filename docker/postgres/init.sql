CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
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
    status VARCHAR(20) DEFAULT 'Pending',
    team TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(255),
    FOREIGN KEY (manager_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tasks (
    id SERIAL PRIMARY KEY,
    project_id INT NOT NULL,
    description TEXT NOT NULL,
    assigned_to INT,
    status VARCHAR(20) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO users (name, email, password, role, phone, address, position, department) VALUES
('Maciej Malina', 'maciej.malina@gmail.com', '$password1', 'admin', '+48 996 202 101', 'Krakow, Poland', 'CEO', 'CEO'),
('John Smith', 'john.smith@example.com', 'password123', 'manager', '+48 600 700 800', 'Warsaw, Poland', 'Project Manager', 'IT'),
('Jane Doe', 'jane.doe@example.com', 'password123', 'manager', '+48 600 111 222', 'Krakow, Poland', 'Project Manager', 'IT'),
('Emily Johnson', 'emily.johnson@example.com', 'password123', 'developer', '+48 600 333 444', 'Gdansk, Poland', 'Frontend Developer', 'IT'),
('Michael Brown', 'michael.brown@example.com', 'password123', 'developer', '+48 600 555 666', 'Poznan, Poland', 'Backend Developer', 'IT'),
('Olivia Green', 'olivia.green@example.com', 'password123', 'tester', '+48 600 777 888', 'Wroclaw, Poland', 'QA Tester', 'Quality Assurance'),
('James White', 'james.white@example.com', 'password123', 'analyst', '+48 600 999 000', 'Lodz, Poland', 'Business Analyst', 'Business'),
('Sophia Black', 'sophia.black@example.com', 'password123', 'designer', '+48 601 222 333', 'Katowice, Poland', 'UI/UX Designer', 'Design');

INSERT INTO projects (name, manager_id, status, team, description) VALUES
('Project Alpha', 1, 'Active', 'Emily Johnson, Michael Brown, Olivia Green', 'Developing a new web platform for client X.'),
('Project Beta', 2, 'Completed', 'Sophia Black, James White', 'Completed the redesign of the company`s intranet.'),
('Project Gamma', 1, 'Pending', 'Michael Brown, Olivia Green', 'Planning phase for a mobile app for internal use.'),
('Project Delta', 2, 'Active', 'Emily Johnson, James White', 'Ongoing updates to the CRM system.'),
('Project Omega', 1, 'On Hold', 'Sophia Black, Emily Johnson, Michael Brown', 'Paused development of the e-commerce platform due to budget constraints.');


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
