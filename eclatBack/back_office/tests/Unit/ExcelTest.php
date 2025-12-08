<?php

namespace Tests\Unit;

use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;

class ExcelTest extends TestCase
{
    /**
     * Test if Excel facade is available.
     *
     * @return void
     */
    public function test_excel_facade_is_available()
    {
        $this->assertTrue(class_exists(\Maatwebsite\Excel\Facades\Excel::class));
    }
}