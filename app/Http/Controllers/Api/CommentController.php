<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::all();
        
        return $this->sendResponse(CommentResource::collection($comments), 'Comments retrieved successfully.');
    }

    public function store(Request $request)
    {
        $comment = Comment::create([
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'user_id' => Auth::user()->id
        ]);
       
        return $this->sendResponse(new CommentResource($comment), 'Comment added successfully.');
    } 

    public function delete(Request $request)
    {
        $comment = Comment::where('id',$request->id)->first();
        $comment->delete();
       
        return $this->sendResponse([], 'Comment deleted successfully.');
    }

    public function update(Request $request)
    {
        $comment = Comment::where('id',$request->id)
                            ->where('post_id',$request->post_id)->first();

        $comment->comment = $request->comment;
        $comment->save();
       
        return $this->sendResponse(new CommentResource($comment), 'Comment updated successfully.');
    }

    public function getPostComment(Request $request)
    {
        $comments = Post::where('id',$request->post_id)->first()->comments;
        // $comments = Comment::where('post_id',$request->post_id)->get();

        return $this->sendResponse(CommentResource::collection($comments), 'Comments retrieved successfully.');
    }

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
