<?php
function envFallback($key) {
    $val = getenv($key) ?: '';
    if ($val !== '') {
        return $val;
    }
    $envFile = dirname(__DIR__, 2) . '/.env';
    if (!is_file($envFile) || !is_readable($envFile)) {
        return '';
    }
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (preg_match('/^' . preg_quote($key, '/') . '\s*=\s*(.*)$/i', $line, $m)) {
            return trim($m[1], "\"' \t\n\r\0\x0B");
        }
    }
    return '';
}

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'InfoLocation' => '',
    'turnstile.siteKey' => '0x4AAAAAADUiF-kmCoQzfovZ',
    'turnstile.secretKey' => '0x4AAAAAADUiF94T_2ksZFISczn0YlfzVaA',
    'brevo.apiKey' => envFallback('BREVO_API_KEY'),
    'blogBaseUrl' => envFallback('BLOG_BASE_URL') ?: (defined('YII_ENV') && YII_ENV === 'prod' ? 'https://www.bricklyhomes.com/blog' : 'https://dev.mydesk.digital/BlogBrickly'),
];
