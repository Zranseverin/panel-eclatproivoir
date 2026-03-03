<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index()
    {
        // Get the count of appointments for the current month
        $monthlyAppointments = Appointment::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();
        
        // Get the count of appointments for the current week
        $weeklyAppointments = Appointment::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->count();
        
        // Calcul du pourcentage de changement par rapport à la semaine dernière
        $lastWeekAppointments = Appointment::whereBetween('created_at', [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek()
            ])
            ->count();
        
        $weeklyChangePercentage = 0;
        if ($lastWeekAppointments > 0) {
            $weeklyChangePercentage = (($weeklyAppointments - $lastWeekAppointments) / $lastWeekAppointments) * 100;
        } elseif ($weeklyAppointments > 0) {
            $weeklyChangePercentage = 100;
        }

        // Rendez-vous validés (is_valide = 1) pour le mois en cours
        $validatedAppointments = Appointment::where('is_valide', 1)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();
        
        // Rendez-vous validés pour la semaine en cours
        $weeklyValidatedAppointments = Appointment::where('is_valide', 1)
            ->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->count();
        
        // Rendez-vous validés pour la semaine dernière
        $lastWeekValidatedAppointments = Appointment::where('is_valide', 1)
            ->whereBetween('created_at', [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek()
            ])
            ->count();
        
        // Calcul du pourcentage de changement pour les rendez-vous validés
        $validatedChangePercentage = 0;
        if ($lastWeekValidatedAppointments > 0) {
            $validatedChangePercentage = (($weeklyValidatedAppointments - $lastWeekValidatedAppointments) / $lastWeekValidatedAppointments) * 100;
        } elseif ($weeklyValidatedAppointments > 0) {
            $validatedChangePercentage = 100;
        }

        return view('admin.dashboard', compact(
            'monthlyAppointments',
            'weeklyAppointments', 
            'weeklyChangePercentage',
            'validatedAppointments',
            'weeklyValidatedAppointments',
            'validatedChangePercentage'
        ));
    }
}