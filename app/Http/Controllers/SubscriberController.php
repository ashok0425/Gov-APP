<?php

namespace App\Http\Controllers;


use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscriber = Subscriber::orderBy('id', 'desc')->get();

        return view('backend.subscriber.index', compact('subscriber'));
    }

    public function create(Request $request)
    {
        $email = [];
        foreach ($request->subscriber as $value) {
            $email[] = $value;
        }

        return view('backend.subscriber.create', compact('email'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:subscribers',

        ]);
        try {
            $category = new Subscriber;
            $file = $request->file('file');

            $category->email = $request->email;

            if ($category->save()) {
                $notification = [
                    'alert-type' => 'success',
                    'message' => 'Thankyou for Subscribing our Newsletter',

                ];

                return redirect()->back()->with($notification);
            } else {
                $notification = [
                    'alert-type' => 'info',
                    'message' => 'Something wrong.Try again later',

                ];

                return redirect()->back()->with($notification);
            }
        } catch (\Throwable $th) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'Something went wrong.Please try again later',

            ];

            return redirect()->back()->with($notification);
        }
    }

    public function send(Request $request)
    {

        foreach ($request->email as $value) {
            $set['email'] = $value;
            $set['title'] = $request->title;
            $set['detail'] = $request->detail;

            Mail::send('mail.subscriberemail', $set, function ($message) use ($set) {
                $message->to($set['email'])
                    ->subject($set['title']);
            });
        }

        return redirect()->route('subscriber');
    }
}
