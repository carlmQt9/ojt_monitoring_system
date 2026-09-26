<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule daily auto-denial of unclosed attendance records at 12:01 AM Manila time
Schedule::command('attendance:auto-deny')
    ->dailyAt('00:01')
    ->timezone('Asia/Manila');
