<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config/auth.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
    header("Location: index.php");
    exit;
}
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$message = '';
$msgType = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Invalid token.";
        $msgType = "error";
    } else {
        $action = $_POST['action'] ?? '';
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        if ($action === 'register') {
            $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
            $res = registerUser($pdo, $name, $email, $password);
            $message = $res['message'];
            $msgType = $res['success'] ? 'success' : 'error';
        } elseif ($action === 'login') {
            $res = loginUser($pdo, $email, $password);
            if ($res['success']) {
                header("Location: index.php");
                exit;
            } else {
                $message = $res['message'];
                $msgType = "error";
            }
        }
    }
}
?>

<div class="auth-container glass-panel reveal active">
    <div class="auth-header">
        <h1>Divine Access</h1>
    </div>
    <?php if ($message): ?>
        <div class="auth-alert <?php echo $msgType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="auth-toggle">
        <button class="toggle-btn active" id="btn-show-login">Login</button>
        <button class="toggle-btn" id="btn-show-register">Register</button>
    </div>

    <form action="login.php" method="POST" id="form-login" class="auth-form active">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"><input
            type="hidden" name="action" value="login">
        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control"
                required></div>
        <button type="submit" class="btn-large">Sign In</button>
    </form>

    <form action="login.php" method="POST" id="form-register" class="auth-form">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"><input
            type="hidden" name="action" value="register">
        <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control"
                minlength="8" required></div>
        <button type="submit" class="btn-large">Create Account</button>
    </form>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>