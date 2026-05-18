<?php
/**
 * Create Admin Credentials Setup Page
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            $error = "Passwords do not match!";
        } elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } else {
            try {
                // Check if user already exists
                $check_stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
                $check_stmt->execute(['username' => $username]);
                if ($check_stmt->fetch()) {
                    $error = "Username already exists! Please choose another one.";
                } else {
                    // Hash password using secure bcrypt
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $insert_stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
                    $insert_stmt->execute([
                        'username' => $username,
                        'password' => $hashed_password,
                        'email'    => $email
                    ]);

                    $success = "Admin user successfully created! You can now log in.";
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin Account | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_PATH; ?>/admin/assets/css/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .setup-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            text-align: center;
        }
        .setup-logo {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 900;
            color: #FFFFFF;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }
        .setup-logo span {
            color: var(--accent);
        }
        .setup-subtitle {
            color: var(--fg2);
            font-size: 14px;
            margin-bottom: 30px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--fg2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--fg3);
            font-size: 16px;
        }
        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
            padding: 12px 14px 12px 42px;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 10px rgba(249, 115, 22, 0.15);
        }
        .btn-setup {
            width: 100%;
            background: var(--accent);
            color: #FFFFFF;
            font-weight: 700;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            transition: all 0.2s;
            margin-top: 10px;
        }
        .btn-setup:hover {
            background: var(--accent2);
            transform: translateY(-1px);
        }
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #FCA5A5;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .success-message {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #A7F3D0;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .back-link {
            display: block;
            margin-top: 25px;
            color: var(--fg3);
            font-size: 12px;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: var(--accent);
        }
    </style>
</head>
<body>

<div class="setup-card">
    <div class="setup-logo">Wander<span>oo</span></div>
    <div class="setup-subtitle">Admin Account Registration Panel</div>

    <?php if (!empty($error)): ?>
        <div class="error-message">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success-message">
            <i class="fa-solid fa-circle-check"></i>
            <span><?php echo htmlspecialchars($success); ?></span>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-user input-icon"></i>
                <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username" required autocomplete="off">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-envelope input-icon"></i>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter admin email" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-lock input-icon"></i>
                <input type="password" class="form-control" id="password" name="password" placeholder="Create a strong password" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="confirm_password">Confirm Password</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-shield-halved input-icon"></i>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
        </div>

        <button type="submit" class="btn-setup">Register Admin Account <i class="fa-solid fa-user-shield" style="margin-left: 8px;"></i></button>
    </form>
    
    <a href="login.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to Login Page</a>
</div>

</body>
</html>
