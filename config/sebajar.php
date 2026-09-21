<?php

$adminWhatsapp = preg_replace('/\D+/', '', (string) env('SEBAJAR_ADMIN_WHATSAPP', ''));

if (str_starts_with($adminWhatsapp, '0')) {
    $adminWhatsapp = '6285526318552' . substr($adminWhatsapp, 1);
}

return [
    // Nomor WhatsApp admin dalam format internasional tanpa tanda +.
    'admin_whatsapp' => $adminWhatsapp,
];
