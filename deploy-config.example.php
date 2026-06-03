<?php

/**
 * Скопируйте в deploy-config.php на сервере (wp-content/deploy-config.php).
 * Файл deploy-config.php не коммитится в git.
 */
return array(
    // Токен из URL деплоя (?token=...)
    'token' => 'your_deploy_token_here',

    // Путь к git, если автоопределение не сработало (узнать по SSH: which git)
    // 'git_binary' => '/usr/local/bin/git',
);
