<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Store a newly created feedback in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'product' => 'nullable|string|max:255',
            'comment' => 'required|string|min:5|max:300',
            'customer_name' => 'nullable|string|max:80',
        ]);

        Feedback::create($validated);

        return response()->json(['message' => 'Feedback saved successfully'], 201);
    }
}
