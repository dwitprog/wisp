<?php

/**
 * Деплой темы из git (запуск из wp-content на сервере).
 * URL: /wp-content/deploy.php?token=...
 *
 * На сервере: скопируйте deploy-config.example.php → deploy-config.php и задайте token.
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$base_dir = __DIR__;
$config = array();

if (is_readable($base_dir . '/deploy-config.php')) {
    $loaded = include $base_dir . '/deploy-config.php';
    if (is_array($loaded)) {
        $config = $loaded;
    }
}

$token = isset($_GET['token']) ? (string) $_GET['token'] : '';
$expected_token = isset($config['token']) ? (string) $config['token'] : '';
if ($expected_token === '') {
    $env_token = getenv('ST_DEPLOY_TOKEN');
    if (is_string($env_token) && $env_token !== '') {
        $expected_token = $env_token;
    }
}

if ($expected_token === '' || !hash_equals($expected_token, $token)) {
    http_response_code(403);
    echo json_encode(
        array(
            'success' => false,
            'error' => 'Invalid or missing token',
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
    exit;
}

/**
 * @return string|null
 */
function st_deploy_find_git(array $config): ?string
{
    if (!empty($config['git_binary']) && is_executable((string) $config['git_binary'])) {
        return (string) $config['git_binary'];
    }

    $candidates = array(
        '/usr/local/bin/git',
        '/usr/bin/git',
        '/bin/git',
        '/opt/bin/git',
        '/opt/local/bin/git',
        '/usr/local/cpanel/3rdparty/bin/git',
    );

    foreach ($candidates as $path) {
        if (is_executable($path)) {
            return $path;
        }
    }

    $path_env = getenv('PATH') ?: '/usr/local/bin:/usr/bin:/bin';
    putenv('PATH=' . $path_env);

    $which = trim((string) shell_exec('command -v git 2>/dev/null'));
    if ($which !== '' && is_executable($which)) {
        return $which;
    }

    $which = trim((string) shell_exec('which git 2>/dev/null'));
    if ($which !== '' && is_executable($which)) {
        return $which;
    }

    return null;
}

/**
 * @return array{0: string, 1: int}
 */
function st_deploy_run(string $git, string $command, string $cwd): array
{
    $path_env = getenv('PATH') ?: '/usr/local/bin:/usr/bin:/bin';
    $full = 'cd ' . escapeshellarg($cwd) . ' && PATH=' . escapeshellarg($path_env) . ' '
        . escapeshellarg($git) . ' ' . $command . ' 2>&1';

    $output = array();
    $code = 0;
    exec($full, $output, $code);

    return array(implode("\n", $output), $code);
}

$git = st_deploy_find_git($config);
$results = array(
    'status_before' => '',
    'stash_output' => '',
    'pull_output' => '',
    'pull_error' => '',
    'status_after' => '',
    'recent_commits' => '',
    'git_binary' => $git,
);

if ($git === null) {
    http_response_code(500);
    echo json_encode(
        array(
            'success' => false,
            'timestamp' => gmdate('Y-m-d H:i:s'),
            'directory' => $base_dir,
            'results' => $results,
            'error' => 'Git executable not found',
            'hint' => 'По SSH выполните: which git — и укажите путь в deploy-config.php (git_binary). Если git нет — попросите хостинг установить git или обновляйте тему через FTP/rsync.',
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
    exit;
}

if (!is_dir($base_dir . '/.git')) {
    http_response_code(500);
    echo json_encode(
        array(
            'success' => false,
            'timestamp' => gmdate('Y-m-d H:i:s'),
            'directory' => $base_dir,
            'results' => $results,
            'error' => 'Not a git repository (.git missing in wp-content)',
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
    exit;
}

list($results['status_before'],) = st_deploy_run($git, 'status -sb', $base_dir);
list($results['stash_output'],) = st_deploy_run($git, 'stash push -u -m "deploy-auto-stash"', $base_dir);
list($results['pull_output'], $pull_code) = st_deploy_run($git, 'pull --ff-only origin main', $base_dir);
list($results['status_after'],) = st_deploy_run($git, 'status -sb', $base_dir);
list($results['recent_commits'],) = st_deploy_run($git, 'log -3 --oneline', $base_dir);

if ($pull_code !== 0) {
    $results['pull_error'] = 'exit code ' . $pull_code;
    http_response_code(500);
    echo json_encode(
        array(
            'success' => false,
            'timestamp' => gmdate('Y-m-d H:i:s'),
            'directory' => $base_dir,
            'results' => $results,
            'error' => 'Git pull failed',
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
    exit;
}

echo json_encode(
    array(
        'success' => true,
        'timestamp' => gmdate('Y-m-d H:i:s'),
        'directory' => $base_dir,
        'results' => $results,
    ),
    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
);
