<?php

namespace Tests\Unit;

use App\Models\TimeInRecord;
use PHPUnit\Framework\TestCase;

class TimeInRecordCalculationTest extends TestCase
{
    public function test_equal_time_in_and_time_out_returns_zero_minutes(): void
    {
        $record = new TimeInRecord([
            'time_in' => '19:25',
            'time_out' => '19:25',
        ]);

        $this->assertSame(0.0, $record->minutes_worked);
        $this->assertSame(0.0, $record->hours_worked);
    }
}
