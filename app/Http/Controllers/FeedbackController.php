<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Notification;
use App\Notifications\FeedbackSubmitted;

class FeedbackController extends Controller
{
    public function submitFeedback(Request $request)
    {
        // Validate the request if needed
        $request->validate([
            'feedback' => 'required|string',
        ]);

        // Create a new feedback instance
        $feedback = new Feedback([
            'content' => $request->input('feedback'),
        ]);

        // Save the feedback to the database
        $feedback->save();

        Notification::route('mail', config('mail.from.address'))
            ->notify(new FeedbackSubmitted($feedback));


        return redirect('aboutUs');

    }
}
