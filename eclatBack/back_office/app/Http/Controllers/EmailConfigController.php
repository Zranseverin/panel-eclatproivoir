<?php

namespace App\Http\Controllers;

use App\Models\EmailConfig;
use Illuminate\Http\Request;

class EmailConfigController extends Controller
{
    /**
     * Display a listing of the email configurations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailConfigs = EmailConfig::all();
        return view('email_configs.index', compact('emailConfigs'));
    }

    /**
     * Show the form for creating a new email configuration.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('email_configs.create');
    }

    /**
     * Store a newly created email configuration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'host' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'encryption' => 'required|string|max:50',
            'port' => 'required|integer',
            'from_address' => 'required|email|max:255',
            'from_name' => 'required|string|max:255',
        ]);

        EmailConfig::create($request->all());

        return redirect()->route('admin.email-configs.index')
                         ->with('success', 'Configuration email créée avec succès.');
    }

    /**
     * Show the form for editing the specified email configuration.
     *
     * @param  \App\Models\EmailConfig  $emailConfig
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailConfig $emailConfig)
    {
        return view('email_configs.edit', compact('emailConfig'));
    }

    /**
     * Update the specified email configuration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailConfig  $emailConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailConfig $emailConfig)
    {
        $request->validate([
            'host' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'encryption' => 'required|string|max:50',
            'port' => 'required|integer',
            'from_address' => 'required|email|max:255',
            'from_name' => 'required|string|max:255',
        ]);

        $emailConfig->update($request->all());

        return redirect()->route('admin.email-configs.index')
                         ->with('success', 'Configuration email mise à jour avec succès.');
    }

    /**
     * Remove the specified email configuration from storage.
     *
     * @param  \App\Models\EmailConfig  $emailConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailConfig $emailConfig)
    {
        $emailConfig->delete();

        return redirect()->route('admin.email-configs.index')
                         ->with('success', 'Configuration email supprimée avec succès.');
    }
}