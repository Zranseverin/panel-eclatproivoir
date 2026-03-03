<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use App\Helpers\EmailHelper;

class NewsletterSubscriberController extends Controller
{
    /**
     * Display a listing of the newsletter subscribers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        // Filter by active status if provided
        if ($request->has('status') && $request->status !== '') {
            $isActive = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $isActive);
        }

        // Search by email if provided
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where('email', 'LIKE', "%{$search}%");
        }

        $subscribers = $query->orderBy('subscribed_at', 'desc')->paginate(15);

        return view('newsletter_subscribers.index', compact('subscribers'));
    }

    /**
     * Store a newly created newsletter subscriber in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email|max:255',
        ]);

        NewsletterSubscriber::create([
            'email' => $request->email,
            'is_active' => 1,
        ]);

        return redirect()->back()->with('success', 'Vous avez été inscrit avec succès à la newsletter.');
    }

    /**
     * Update the specified subscriber's active status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsletterSubscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsletterSubscriber $subscriber)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $subscriber->update([
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.newsletter-subscribers.index')
                         ->with('success', 'Statut du subscriber mis à jour avec succès.');
    }

    /**
     * Remove the specified subscriber from storage.
     *
     * @param  \App\Models\NewsletterSubscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.newsletter-subscribers.index')
                         ->with('success', 'Subscriber supprimé avec succès.');
    }

    /**
     * Bulk delete subscribers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:newsletter_subscribers,id',
        ]);

        NewsletterSubscriber::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.newsletter-subscribers.index')
                         ->with('success', 'Subscribers sélectionnés supprimés avec succès.');
    }

    
    
    /**
     * Send email to selected subscribers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'subscriber_ids' => 'required|string',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        
        // Get subscriber IDs
        $subscriberIds = explode(',', $request->subscriber_ids);
        
        // Get subscribers
        $subscribers = NewsletterSubscriber::whereIn('id', $subscriberIds)
                                          ->where('is_active', 1)
                                          ->get();
        
        if ($subscribers->isEmpty()) {
            return redirect()->route('admin.newsletter-subscribers.index')
                             ->with('error', 'Aucun abonné actif trouvé parmi les sélectionnés.');
        }
        
        // Send email to each subscriber
        $sentCount = 0;
        foreach ($subscribers as $subscriber) {
            $result = EmailHelper::sendGenericEmail(
                $subscriber->email,
                '', // No name needed
                $request->subject,
                nl2br(e($request->body)), // HTML body
                $request->body // Plain text body
            );
            
            if ($result) {
                $sentCount++;
            }
        }
        
        return redirect()->route('admin.newsletter-subscribers.index')
                         ->with('success', "{$sentCount} emails envoyés avec succès.");
    }
}