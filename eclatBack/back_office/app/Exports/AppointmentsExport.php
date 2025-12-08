<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AppointmentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Appointment::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Type de Service',
            'Fréquence',
            'Nom du Client',
            'Email',
            'Date Souhaitée',
            'Téléphone',
            'Date de Création',
            'Date de Mise à Jour',
        ];
    }

    /**
     * @param Appointment $appointment
     * @return array
     */
    public function map($appointment): array
    {
        return [
            $appointment->id,
            $appointment->service_type,
            $appointment->frequency,
            $appointment->name,
            $appointment->email,
            $appointment->desired_date,
            $appointment->phone,
            $appointment->created_at,
            $appointment->updated_at,
        ];
    }
}