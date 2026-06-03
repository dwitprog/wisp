<?php

/**
 * Скопируйте в deploy-config.php на сервере (wp-content/deploy-config.php).
 * Файл deploy-config.php не коммитится в git.
 *
 * Альтернатива: файл wp-content/deploy.token — одна строка с токеном (без <?php).
 */
return array(
    // Тот же token, что в URL: deploy.php?token=...
    'token' => 'your_deploy_token_here',

    // Путь к git, если автоопределение не сработало (узнать по SSH: which git)
    // 'git_binary' => '/usr/local/bin/git',
);
