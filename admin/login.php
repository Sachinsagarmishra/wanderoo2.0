<?php
/**
 * Admin Login Page
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid username or password!";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
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
    <title>Admin Login | <?php echo SITE_NAME; ?></title>
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
        .login-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            text-align: center;
        }
        .login-logo {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 900;
            color: #FFFFFF;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }
        .login-logo span {
            color: var(--accent);
        }
        .login-subtitle {
            color: var(--fg2);
            font-size: 14px;
            margin-bottom: 30px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
            position: relative;
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
        .btn-login {
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
        .btn-login:hover {
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
        .setup-link {
            display: block;
            margin-top: 25px;
            color: var(--fg3);
            font-size: 12px;
            transition: color 0.2s;
        }
        .setup-link:hover {
            color: var(--accent);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-logo">Wander<span>oo</span></div>
    <div class="login-subtitle">Control Panel Authentication</div>

    <?php if (!empty($error)): ?>
        <div class="error-message">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-user input-icon"></i>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required autocomplete="off">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-lock input-icon"></i>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
        </div>

        <button type="submit" class="btn-login">Login Securely <i class="fa-solid fa-arrow-right-to-bracket" style="margin-left: 8px;"></i></button>
    </form>
</div>

</body>
</html>
