<?php

namespace App\Http\Controllers;
use App\Helpers\EmailHelper;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show the login form for admins
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login
     */
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Get the authenticated admin
            $admin = Auth::guard('admin')->user();
            
            // Track login information
            $this->trackAdminLogin($admin, $request);
            
            // Send login notification email
            $this->sendLoginNotification($admin);

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Track admin login information
     */
    private function trackAdminLogin(Admin $admin, Request $request)
    {
        // Get local IP address
        $localIp = $this->getLocalIpAddress();
        
        // Get internet IP address
        $internetIp = $this->getInternetIpAddress($request);
        
        // Update admin with login information
        $admin->update([
            'last_login_ip' => $localIp,
            'last_login_internet_ip' => $internetIp,
            'last_login_at' => now(),
        ]);
    }

    /**
     * Get local IP address
     */
    private function getLocalIpAddress()
    {
        // Try to get local IP from server variables
        if (!empty($_SERVER['SERVER_ADDR'])) {
            return $_SERVER['SERVER_ADDR'];
        }
        
        // Fallback method
        $ips = gethostbynamel(gethostname());
        return !empty($ips) ? $ips[0] : '127.0.0.1';
    }

    /**
     * Get internet IP address
     */
    private function getInternetIpAddress(Request $request)
    {
        // Check various headers for client IP
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];
        
        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = explode(',', $_SERVER[$header])[0];
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
                    return $ip;
                }
            }
        }
        
        // Fallback to REMOTE_ADDR
        return $request->ip();
    }

    /**
     * Send login notification email to admin
     */
    private function sendLoginNotification(Admin $admin)
    {
        $localIp = $admin->last_login_ip ?? 'N/A';
        $internetIp = $admin->last_login_internet_ip ?? 'N/A';
        $loginTime = $admin->last_login_at ? $admin->last_login_at->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s');
        
        $subject = 'Nouvelle Connexion à Votre Compte Admin';
        
        $htmlBody = "
        <html>
        <head>
            <title>Nouvelle Connexion à Votre Compte Admin</title>
        </head>
        <body>
            <h2>Bonjour {$admin->nom_complet},</h2>
            <p>Nous vous informons qu'une nouvelle connexion à votre compte administrateur a été détectée.</p>
            <p><strong>Date et heure de connexion :</strong> {$loginTime}</p>
            <p><strong>Adresse IP locale :</strong> {$localIp}</p>
            <p><strong>Adresse IP Internet :</strong> {$internetIp}</p>
            
            <p>Si cette connexion était légitime, vous pouvez ignorer ce message.</p>
            <p>Si vous ne reconnaissez pas cette activité, veuillez contacter immédiatement le support technique.</p>
            
            <p>Cordialement,<br>L'équipe de sécurité</p>
        </body>
        </html>
        ";
        
        $plainTextBody = "Bonjour {$admin->nom_complet},

Nous vous informons qu'une nouvelle connexion à votre compte administrateur a été détectée.

Date et heure de connexion : {$loginTime}
Adresse IP locale : {$localIp}
Adresse IP Internet : {$internetIp}

Si cette connexion était légitime, vous pouvez ignorer ce message.
Si vous ne reconnaissez pas cette activité, veuillez contacter immédiatement le support technique.

Cordialement,
L'équipe de sécurité";
        
        // Send the email using our EmailHelper
        EmailHelper::sendGenericEmail(
            $admin->email,
            $admin->nom_complet,
            $subject,
            $htmlBody,
            $plainTextBody
        );
    }

    /**
     * Show the registration form for admins
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    /**
     * Handle admin registration
     */
    public function register(AdminRegisterRequest $request)
    {
        $admin = Admin::create([
            'nom_complet' => $request->nom_complet,
            'numero' => $request->numero,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}