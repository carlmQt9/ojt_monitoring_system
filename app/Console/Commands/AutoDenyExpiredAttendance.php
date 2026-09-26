<?php

namespace App\Console\Commands;

use App\Helpers\AttendanceHelper;
use Illuminate\Console\Command;

class AutoDenyExpiredAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:auto-deny {--student-id= : Optional student ID to limit processing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-deny expired unclosed attendance records and cap morning sessions at noon when needed.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $studentId = $this->option('student-id');
        $processed = AttendanceHelper::processAutoTimeoutsAndDenials($studentId !== null ? (int) $studentId : null);

        $this->info(sprintf(
            'Auto-deny completed: %d expired record(s) denied, %d morning timeout(s) applied.',
            $processed['denied_count'],
            $processed['morning_auto_timeout_count']
        ));

        return self::SUCCESS;
    }
}
