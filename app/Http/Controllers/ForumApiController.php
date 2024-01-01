<?php

namespace App\Http\Controllers;

use App\Http\Requests\DislikeReplyRequest;
use App\Http\Requests\LikeReplyRequest;
use App\Jobs\DislikeReply;
use App\Jobs\LikeReply;
use App\Models\Reply;
use GSVnet\Markdown\MarkdownConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumApiController extends Controller
{
    public function preview(Request $request)
    {
        $data = $request->get('text');
        return MarkdownConverter::convertMarkdownToHtml($data);
    }

    public function quoteReply(Reply $reply)
    {
        $thread = $reply->thread;

        $thread->requireAccess();

        return response()->json([
            'author' => $reply->author->username,
            'markdown' => $reply->body
        ]);
    }

    public function likeReply(LikeReplyRequest $request, Reply $reply)
    {
        // All methods in this controller use the auth middleware
        LikeReply::dispatch(Auth::user(), $reply);

        return response()->json();
    }

    public function dislikeReply(DislikeReplyRequest $request, Reply $reply)
    {
        // All methods in this controller use the auth middleware
        DislikeReply::dispatch(Auth::user(), $reply);

        return response()->json();
    }
}
