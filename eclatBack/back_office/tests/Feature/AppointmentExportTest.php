<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Appointment;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentExportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_export_appointments_to_excel()
    {
        // Create some test appointments
        Appointment::factory()->count(3)->create();

        // Mock the Excel facade
        Excel::fake();

        // Make a request to the export route
        $response = $this->get(route('admin.appointments.export'));

        // Assert that the response is successful
        $response->assertSuccessful();

        // Assert that Excel was called with the correct export class
        Excel::assertDownloaded('rendez-vous.xlsx');
    }
}