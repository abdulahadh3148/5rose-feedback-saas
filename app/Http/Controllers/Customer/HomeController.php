<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $approvedReviews = Feedback::where('status', 'approved')
            ->latest('updated_at')
            ->get();
            
        $reviewCount = $approvedReviews->count();
        $averageRating = $reviewCount > 0 ? $approvedReviews->avg('rating') : 0;

        return view('customer.home', compact('approvedReviews', 'reviewCount', 'averageRating'));
    }
}
