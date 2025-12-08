<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Exports\AppointmentsExport;
use App\Imports\AppointmentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     */
    public function index(Request $request)
    {
        $query = Appointment::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('service_type', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Apply date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Order by creation date descending
        $appointments = $query->orderBy('created_at', 'desc')->get();

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required|string|max:100',
            'frequency' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'desired_date' => 'required|date',
            'phone' => 'required|string|max:20',
        ]);

        $appointment = Appointment::create($request->all());

        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Rendez-vous créé avec succès.');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'service_type' => 'required|string|max:100',
            'frequency' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'desired_date' => 'required|date',
            'phone' => 'required|string|max:20',
        ]);

        $appointment->update($request->all());

        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Rendez-vous supprimé avec succès.');
    }

    /**
     * Export appointments to Excel
     */
    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Only apply date filter if both dates are provided and not empty
        if (!empty($startDate) && !empty($endDate)) {
            return Excel::download(new AppointmentsExport($startDate, $endDate), 'rendez-vous.xlsx');
        } else {
            // Export all appointments if no date range is specified
            return Excel::download(new AppointmentsExport(), 'rendez-vous.xlsx');
        }
    }

    /**
     * Import appointments from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new AppointmentsImport, $request->file('file'));

        return redirect()->route('admin.appointments.index')
                         ->with('success', 'Rendez-vous importés avec succès.');
    }
}