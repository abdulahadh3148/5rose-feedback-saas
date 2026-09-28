<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackModerationController extends Controller
{
    public function index(Request $request)
    {
        $allowedStatuses = [
            'pending',
            'approved',
            'rejected',
        ];

        $status = $request->query('status', 'pending');

        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'pending';
        }

        $search = trim(
            (string) $request->query('search', '')
        );

        $query = Feedback::query()
            ->where('status', $status);

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'customer_name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'product',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'comment',
                    'like',
                    "%{$search}%"
                );

            });

        }

        $feedbacks = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        $counts = [
            'pending' => Feedback::where(
                'status',
                'pending'
            )->count(),

            'approved' => Feedback::where(
                'status',
                'approved'
            )->count(),

            'rejected' => Feedback::where(
                'status',
                'rejected'
            )->count(),
        ];


        return view(
            'admin.feedback.index',
            compact(
                'feedbacks',
                'counts',
                'status',
                'search'
            )
        );
    }


    public function show(Feedback $feedback)
    {
        return view(
            'admin.feedback.show',
            compact('feedback')
        );
    }


    public function approve(Feedback $feedback)
    {
        $feedback->status = 'approved';

        $feedback->approved_at = now();

        $feedback->rejected_at = null;

        $feedback->save();


        return back()->with(
            'success',
            'Feedback approved and ready for public display.'
        );
    }


    public function reject(Feedback $feedback)
    {
        $feedback->status = 'rejected';

        $feedback->rejected_at = now();

        $feedback->approved_at = null;

        $feedback->save();


        return back()->with(
            'success',
            'Feedback rejected successfully.'
        );
    }


    public function moveToPending(Feedback $feedback)
    {
        $feedback->status = 'pending';

        $feedback->approved_at = null;

        $feedback->rejected_at = null;

        $feedback->save();


        return back()->with(
            'success',
            'Feedback moved back to pending.'
        );
    }
}
