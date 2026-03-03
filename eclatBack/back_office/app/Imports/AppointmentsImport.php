<?php

namespace App\Imports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AppointmentsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Appointment([
            'service_type' => $row['type_de_service'] ?? $row['service_type'],
            'frequency' => $row['frequence'] ?? $row['frequency'],
            'name' => $row['nom_du_client'] ?? $row['name'],
            'email' => $row['email'],
            'desired_date' => $row['date_souhaitee'] ?? $row['desired_date'],
            'phone' => $row['telephone'] ?? $row['phone'],
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'service_type' => 'required|string|max:100',
            'frequency' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'desired_date' => 'required|date',
            'phone' => 'required|string|max:20',
        ];
    }
}