<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link rel="stylesheet" href="/css/project.css">
    <script>
        function toggleTaskForm(taskId) {
            const form = document.getElementById(`task-form-${taskId}`);
            const isHidden = form.style.display === "none" || form.style.display === "";
            form.style.display = isHidden ? "block" : "none";
        }
        function toggleEdit(field, valueId, inputId, formId) {

            const valueElement = document.getElementById(valueId);
            const inputElement = document.getElementById(inputId);
            const formElement = document.getElementById(formId);

            const isHidden = inputElement.style.display === "none" || inputElement.style.display === "";

            valueElement.style.display = isHidden ? "none" : "inline";
            inputElement.style.display = isHidden ? "inline" : "none";
            formElement.style.display = isHidden ? "inline-block" : "none";

            if (isHidden) {
                inputElement.focus();
            }
        }
        async function updateTaskStatus(taskId, status) {
        const response = await fetch('/update-task', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ taskId, status })
        });

        if (response.ok) {
            alert('Task status updated successfully!');
        } else {
            alert('Failed to update task status.');
        }
        }

        async function addTask() {
            const description = document.getElementById('taskDescription').value;
            const projectId = <?= $project['id'] ?>;

            const response = await fetch('/add-task', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ projectId, description })
            });

            if (response.ok) {
                const newTask = await response.json();
                const tasksList = document.getElementById('tasks-list');
                const newTaskHtml = `
                    <li>
                        <span>${newTask.description}</span>
                        <strong>Assigned To:</strong> Unassigned
                        <strong>Status:</strong>
                        <select onchange="updateTaskStatus(${newTask.id}, this.value)">
                            <option value="Pending" selected>Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </li>
                `;
                tasksList.insertAdjacentHTML('beforeend', newTaskHtml);
                alert('Task added successfully!');
            } else {
                alert('Failed to add task.');
            }
        }
    </script>
</head>
<body>
    <div class="header">
        <button class="back-button" onclick="location.href='/dashboard'">Back</button>
        <h1><?= htmlspecialchars($project['name'] ?? 'Unknown Project') ?></h1>
        <div class="nav-links">
            <a href="/profile" class="account">Account</a>
            <a href="/logout" class="account">Logout</a>
        </div>
    </div>
    <div class="content">
    <div class="project-details">
    <h2>General Information</h2>
    
    <?php 
    $isManager = $_SESSION['user']['role'] === 'manager' || $_SESSION['user']['role'] === 'admin'; 
    ?>

    <p>
        <strong>Name:</strong> 
        <?php if ($isManager): ?>
            <span id="project-name"><?= htmlspecialchars($project['name']) ?></span>
            <button onclick="toggleEdit('name', 'project-name', 'project-name-input', 'project-name-save')" class="edit-button">Edit</button>
            <form id="project-name-save" style="display: none;" method="POST" action="/update-project">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                <input type="hidden" name="field" value="name">
                <input id="project-name-input" type="text" name="value" value="<?= htmlspecialchars($project['name']) ?>" style="display: none;">
                <button class="edit-button">Save</button>
            </form>
        <?php else: ?>
            <?= htmlspecialchars($project['name']) ?>
        <?php endif; ?>
    </p>

    <p>
        <strong>Description:</strong> 
        <?php if ($isManager): ?>
            <span id="project-description"><?= htmlspecialchars($project['description']) ?></span>
            <button onclick="toggleEdit('description', 'project-description', 'project-description-input', 'project-description-save')" class="edit-button">Edit</button>
            <form id="project-description-save" style="display: none;" method="POST" action="/update-project">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                <input type="hidden" name="field" value="description">
                <textarea id="project-description-input" name="value" style="display: none;"><?= htmlspecialchars($project['description']) ?></textarea>
                <button class="edit-button">Save</button>
            </form>
        <?php else: ?>
            <?= htmlspecialchars($project['description']) ?>
        <?php endif; ?>
    </p>

    <p>
        <strong>Team:</strong> 
        <?php if ($isManager): ?>
            <span id="project-team"><?= htmlspecialchars($project['team']) ?></span>
            <button onclick="toggleEdit('team', 'project-team', 'project-team-input', 'project-team-save')" class="edit-button">Edit</button>
            <form id="project-team-save" style="display: none;" method="POST" action="/update-project">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                <input type="hidden" name="field" value="team">
                <textarea id="project-team-input" name="value" style="display: none;"><?= htmlspecialchars($project['team']) ?></textarea>
                <button class="edit-button">Save</button>
            </form>
        <?php else: ?>
            <?= htmlspecialchars($project['team']) ?>
        <?php endif; ?>
    </p>
        <div class="tasks">
    <h2>Tasks</h2>
    <?php if (empty($tasks)): ?>
        <p>No tasks available for this project.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <span onclick="toggleTaskForm(<?= $task['id'] ?>)" style="cursor: pointer;">
                        <strong>Task:</strong> <?= htmlspecialchars($task['description']) ?>
                    </span>
                    <span><strong>Assigned To:</strong> <?= htmlspecialchars($task['assigned_to'] ?? 'Unassigned') ?></span>
                    <span><strong>Status:</strong> <?= htmlspecialchars($task['status']) ?></span>

                    <?php 
                    $isManager = $_SESSION['user']['role'] === 'manager' || $_SESSION['user']['role'] === 'admin';
                    $isAssigned = $_SESSION['user']['id'] == $task['assigned_to'];

                    if ($isManager || $isAssigned): ?>
                        <form id="task-form-<?= $task['id'] ?>" method="POST" action="/update-task-status" style="display: none; margin-top: 10px;">
                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                            <select name="status" required>
                                <option value="Pending" <?= $task['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="In Progress" <?= $task['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="Completed" <?= $task['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                            </select>
                            <button type="button" class="edit-button">Edit</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
</div>
</div>
</body>
</html>
