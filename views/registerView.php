<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <a href="/login">Login</a>
    <form action="#" method="POST">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div>
            <label for="firstname">Firstname:</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>

        <div>
            <label for="lastname">Lastname:</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="">-- Select a role --</option>
                <option value="Ecole">Ecole</option>
                <option value="Entreprise">Entreprise</option>
                <option value="Admin">Admin</option>
                <option value="Default">Default</option>
            </select>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Register</button>
    </form>
    <?php if ($error): ?>
        <div style="color: red;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div style="color: green;"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
</body>
</html>