<?php
namespace App\Http\Controllers;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class SubscriberController extends Controller
{
    public function index()
    {
        $subscriber = Subscriber::all();

        return response()->json([
            'status' => true,
            'message' => 'Websites fetched successfully.',
            'data' => [
                'subscribers' => $subscriber,
            ],
        ]);
    }
    public function create(Request $request)
    {
        $email = $request->get('email');
        $website_id = $request ->get('website_id');
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('subscribers', 'email')->where('website_id', $website_id),
            ],
            'website_id' => 'required'
        ]);

        Subscriber::create([
            'email' => $email,
            'website_id' => $website_id
        ]);

        return response('Post created successfully');
    }


    public function delete(Request $request)
    {

        $email = $request ->get('email');
        $user= Subscriber::where('email', $email)->first();
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'Successfully Deleted']);
        } else {
            return response()->json(['message' => 'User not found']);
        }
    }
}

