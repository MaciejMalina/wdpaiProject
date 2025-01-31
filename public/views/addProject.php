<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Project</title>
    <link rel="stylesheet" href="/css/addProject.css">
</head>
<body>
    <div class="container">
    <a href="/dashboard" class="back-button">Back</a>
        <h1>Add New Project</h1>
        <form method="POST" action="/createProject">
            <label for="name"><strong>Project Name:</strong></label>
            <input type="text" id="name" name="name" required>

            <label for="description"><strong>Description:</strong></label>
            <textarea id="description" name="description" required></textarea>

            <label for="manager_id"><strong>Manager:</strong></label>
            <select id="manager_id" name="manager_id">
                <?php foreach ($managers as $manager): ?>
                    <option value="<?= $manager['id'] ?>"><?= htmlspecialchars($manager['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="team">Select Team Members:</label>
            <select name="team[]" id="team" multiple>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?> (<?= $user['role'] ?>)</option>
                <?php endforeach; ?>
            </select>

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="Active">Active</option>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
                <option value="On Hold">On Hold</option>
            </select>

         <button type="submit">Create Project</button>
        </form>
    </div>
</body>
</html>
