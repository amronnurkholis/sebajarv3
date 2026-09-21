<?php

namespace App\Services;

use App\Models\Setting;
use Carbon\Carbon;

class RentalScheduleService
{
    public function settings(): array
    {
        return [
            'automatic' => Setting::value('rental_automatic', '1') === '1',
            'manual_open' => Setting::value('rental_manual_open', '1') === '1',
            'open_time' => Setting::value('rental_open_time', '07:00'),
            'close_time' => Setting::value('rental_close_time', '23:00'),
            'closed_message' => Setting::value('rental_closed_message', 'Penyewaan sedang ditutup. Silakan kembali saat layanan dibuka.'),
        ];
    }

    public function status(): array
    {
        $settings = $this->settings();
        $now = Carbon::now('Asia/Jakarta');

        if (! $settings['automatic']) {
            return $this->makeStatus($settings['manual_open'], null, $settings, $now);
        }

        $openAt = $now->copy()->setTimeFromTimeString($settings['open_time']);
        $closeAt = $now->copy()->setTimeFromTimeString($settings['close_time']);
        $crossesMidnight = $closeAt->lessThanOrEqualTo($openAt);

        if ($crossesMidnight) {
            $isOpen = $now->greaterThanOrEqualTo($openAt) || $now->lessThan($closeAt);
            $nextChange = $isOpen
                ? ($now->greaterThanOrEqualTo($openAt) ? $closeAt->addDay() : $closeAt)
                : $openAt;
        } else {
            $isOpen = $now->greaterThanOrEqualTo($openAt) && $now->lessThan($closeAt);
            $nextChange = $isOpen ? $closeAt : ($now->lessThan($openAt) ? $openAt : $openAt->addDay());
        }

        return $this->makeStatus($isOpen, $nextChange, $settings, $now);
    }

    private function makeStatus(bool $isOpen, ?Carbon $nextChange, array $settings, Carbon $now): array
    {
        return [
            'is_open' => $isOpen,
            'automatic' => $settings['automatic'],
            'next_change' => $nextChange?->toIso8601String(),
            'next_change_label' => $nextChange?->translatedFormat('H:i') . ' WIB',
            'closed_message' => $settings['closed_message'],
            'server_time' => $now->toIso8601String(),
        ];
    }
}
