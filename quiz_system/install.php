<?php
// Installation script for Quiz System
session_start();

// Check if PHP version is compatible
$min_php_version = '7.4.0';
if (version_compare(PHP_VERSION, $min_php_version, '<')) {
    die("Your PHP version must be {$min_php_version} or higher to run this application. Your current version is " . PHP_VERSION);
}

// Check if required PHP extensions are installed
$required_extensions = ['pdo', 'pdo_mysql', 'mbstring', 'json'];
$missing_extensions = [];

foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

if (!empty($missing_extensions)) {
    die("The following PHP extensions are required but missing: " . implode(', ', $missing_extensions));
}

// Define constants
define('ROOT_PATH', dirname(__FILE__));
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://" . $_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$base_url = rtrim($base_url, '/install.php');

// Process form submission
$db_error = '';
$config_error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database configuration
    $db_host = trim($_POST['db_host']);
    $db_name = trim($_POST['db_name']);
    $db_user = trim($_POST['db_user']);
    $db_pass = trim($_POST['db_pass']);
    
    // Test database connection
    try {
        $dsn = "mysql:host={$db_host};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);
        
        // Create database if not exists
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}`");
        $pdo->exec("USE `{$db_name}`");
        
        // Read the SQL file
        $sql_file = file_get_contents(ROOT_PATH . '/database/setup.sql');
        
        // Execute the SQL
        $pdo->exec($sql_file);
        
        // Update database configuration file
        $db_config = "<?php
// Database configuration
define('DB_HOST', '{$db_host}');
define('DB_USER', '{$db_user}');
define('DB_PASS', '{$db_pass}');
define('DB_NAME', '{$db_name}');
?>";

        file_put_contents(ROOT_PATH . '/app/config/database.php', $db_config);
        
        // Update app configuration
        $site_name = trim($_POST['site_name']);
        $app_url = trim($_POST['app_url']);
        
        $app_config = "<?php
// Application configuration
define('SITE_NAME', '{$site_name}');

// URL Root
define('URL_ROOT', '{$app_url}');

// App Root
define('APP_ROOT', dirname(dirname(__FILE__)));

// Set timezone
date_default_timezone_set('Europe/Warsaw');
?>";

        file_put_contents(ROOT_PATH . '/app/config/config.php', $app_config);
        
        $success = true;
    } catch (PDOException $e) {
        $db_error = $e->getMessage();
    } catch (Exception $e) {
        $config_error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalacja - System Testowania Wiedzy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 40px;
        }
        .installer-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .step {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="installer-container">
            <div class="text-center mb-4">
                <h1><i class="fas fa-graduation-cap"></i> System Testowania Wiedzy</h1>
                <h3>Instalacja</h3>
            </div>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <h4><i class="fas fa-check-circle"></i> Instalacja zakończona pomyślnie!</h4>
                    <p>System został poprawnie zainstalowany. Możesz teraz zalogować się na domyślne konto nauczyciela:</p>
                    <ul>
                        <li><strong>Login:</strong> teacher</li>
                        <li><strong>Hasło:</strong> password</li>
                    </ul>
                    <p>Ze względów bezpieczeństwa, zalecamy usunięcie pliku <code>install.php</code> po zakończeniu instalacji.</p>
                    <div class="mt-4">
                        <a href="<?php echo $base_url; ?>" class="btn btn-primary btn-lg">Przejdź do aplikacji</a>
                    </div>
                </div>
            <?php else: ?>
                <?php if (!empty($db_error)): ?>
                    <div class="alert alert-danger">
                        <strong>Błąd połączenia z bazą danych:</strong> <?php echo $db_error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($config_error)): ?>
                    <div class="alert alert-danger">
                        <strong>Błąd konfiguracji:</strong> <?php echo $config_error; ?>
                    </div>
                <?php endif; ?>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div>Sprawdzanie wymagań systemowych</div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Wersja PHP</td>
                                    <td><?php echo PHP_VERSION; ?></td>
                                    <td>
                                        <?php if (version_compare(PHP_VERSION, $min_php_version, '>=')): ?>
                                            <span class="text-success"><i class="fas fa-check"></i> OK</span>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fas fa-times"></i> Za niska wersja</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php foreach ($required_extensions as $ext): ?>
                                    <tr>
                                        <td>Rozszerzenie <?php echo $ext; ?></td>
                                        <td></td>
                                        <td>
                                            <?php if (extension_loaded($ext)): ?>
                                                <span class="text-success"><i class="fas fa-check"></i> OK</span>
                                            <?php else: ?>
                                                <span class="text-danger"><i class="fas fa-times"></i> Brak</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>Uprawnienia do zapisu w katalogu /app/config</td>
                                    <td></td>
                                    <td>
                                        <?php if (is_writable(ROOT_PATH . '/app/config')): ?>
                                            <span class="text-success"><i class="fas fa-check"></i> OK</span>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fas fa-times"></i> Brak</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div>Konfiguracja aplikacji</div>
                </div>
                
                <form method="post" action="">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Konfiguracja bazy danych</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="db_host" class="form-label">Host bazy danych</label>
                                    <input type="text" class="form-control" id="db_host" name="db_host" value="localhost" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="db_name" class="form-label">Nazwa bazy danych</label>
                                    <input type="text" class="form-control" id="db_name" name="db_name" value="quiz_system" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="db_user" class="form-label">Użytkownik bazy danych</label>
                                    <input type="text" class="form-control" id="db_user" name="db_user" value="root" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="db_pass" class="form-label">Hasło bazy danych</label>
                                    <input type="password" class="form-control" id="db_pass" name="db_pass" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Konfiguracja aplikacji</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="site_name" class="form-label">Nazwa witryny</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name" value="System Testowania Wiedzy" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="app_url" class="form-label">URL aplikacji</label>
                                    <input type="text" class="form-control" id="app_url" name="app_url" value="<?php echo $base_url; ?>" required>
                                    <div class="form-text">Na przykład: http://localhost/quiz_system</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-cog"></i> Zainstaluj system
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4 text-muted">
            <p>System Testowania Wiedzy &copy; <?php echo date('Y'); ?></p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
