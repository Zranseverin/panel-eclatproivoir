<?php

namespace App\Http\Controllers;

use App\Models\SendMail;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    /**
     * Display a listing of the sent emails.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SendMail::query();

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search in subject, recipient name or email if provided
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'LIKE', "%{$search}%")
                  ->orWhere('to_name', 'LIKE', "%{$search}%")
                  ->orWhere('to_email', 'LIKE', "%{$search}%");
            });
        }

        $sentEmails = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('sent_emails.index', compact('sentEmails'));
    }

    /**
     * Display the specified sent email.
     *
     * @param  \App\Models\SendMail  $sendMail
     * @return \Illuminate\Http\Response
     */
    public function show(SendMail $sendMail)
    {
        return view('sent_emails.show', compact('sendMail'));
    }
}