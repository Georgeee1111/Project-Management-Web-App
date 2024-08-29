<!DOCTYPE html>
<html>
<head>
    <title>Task Assigned</title>
</head>
<body>
    <h1>Hello, {{ $userName }}</h1>
    <p>You have been assigned a new task: {{ $taskName }}</p>
    <p>Task Details:</p>
    <ul>
        <li>Task ID: {{ $task->id }}</li>
        <li>Task Name: {{ $task->name }}</li>
        <li>Description: {{ $task->description }}</li>
        <li>Due Date: {{ $task->due_date }}</li>
        <li>Status: {{ $task->status }}</li>
    </ul>
    <p>Thank you.</p>
</body>
</html>
