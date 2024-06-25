<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\MarketingMessage;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MarketingMessage as MarketingMessageMail;

class MarketingMessageController extends Controller
{
    public function index()
    {
        $subscribedUsers = Subscription::all();
        $allUsers = User::all();

        return view('marketing_admindash', compact('subscribedUsers', 'allUsers'));
    }

    public function sendMessage(Request $request)
    {
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'send_to' => 'required|in:all,subscribed',
        ]);

        // Initialize users array
        $users = [];

        // Get the users or subscriptions to send the message to
        if ($request->input('send_to') === 'all') {
            $users = User::all();
            $subscriptions = Subscription::all();
            foreach ($subscriptions as $subscription) {
                $users[] = (object) ['id' => null, 'email' => $subscription->email];
            }
        } else if ($request->input('send_to') === 'subscribed') {
            $subscriptions = Subscription::all();
            foreach ($subscriptions as $subscription) {
                $users[] = (object) ['id' => null, 'email' => $subscription->email];
            }
        }
    

        foreach ($users as $user) {
            if ($user->id !== null) {
                $marketingMessage = MarketingMessage::create([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'user_id' => $user->id,
                ]);
            }
        
            // Get the user's email address
            $userEmail = $user->email;
        
            // Log information about the email sending process
            Log::info("Sending email to user ID $user->id, Email: $userEmail");
        
            // Send email to the user
            try {
                Mail::to($userEmail)->send(new MarketingMessageMail(
                    $request->input('title'),
                    $request->input('content'), 
                ));
                Log::info("Email sent successfully to user ID $user->id, Email: $userEmail");
            } catch (\Exception $e) {
                Log::error("Error sending email to user ID $user->id, Email: $userEmail. Error: " . $e->getMessage());
            }
        }

    
        return redirect()->route('marketing_admindash')->with('success', [
            'message' => 'Emails sent successfully!',
            'duration' => 3000,
        ]);

        return redirect()->route('marketing_admindash')->with('error', [
            'message' => 'Error sending Emails!',
            'duration' => 3000,
        ]);
    }
}
