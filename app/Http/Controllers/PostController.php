<?php
namespace App\Http\Controllers;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Sender;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class PostController extends Controller
{
    public function index(Post $post)
    {
        $posts = Post::all();
        return response()->json([
            'status' => true,
            'message' => 'Posts fetched successfully.',
            'data' => [
                'posts' => $posts,
            ],
        ]);
    }

    public function create(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $website_id = $request ->get('website_id');
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts', 'title')->where('website_id', $website_id),
            ],
            'description' => 'required',
            'website_id' => 'required'
        ]);


        $new_post = Post::create([
            'title' => $title,
            'description' => $description,
            'website_id' => $website_id
        ]);

        $emails = Subscriber::select("email")->where("website_id",$website_id)->get();
        foreach ($emails as $email)
        {
            Sender::create([
                'post_id' => $new_post->id,
                'email' => $email->email,
                'website_id' => $website_id,
                "is_send" => '0'
            ]);
        }
        return response('Post created successfully');
    }
    public function delete(Request $request)
    {
        $title = $request ->get('title');
        $website_id = $request->get('website_id');
        $request->validate([
            'title' => 'required',
            'website_id' => 'required'
        ]);
        $post= Post::where('title', $title)->
                     where('website_id',$website_id)->first();
        if ($post) {
            $post->delete();
            return response()->json(['message' => 'Successfully Deleted']);
        } else {
            return response()->json(['message' => 'Post not found']);
        }
    }

}

