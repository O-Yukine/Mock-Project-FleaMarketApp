<?php

namespace App\Http\Controllers;


use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function makeComment(CommentRequest $request, $item_id)
    {
        Comment::create([
            'product_id' => $item_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment
        ]);

        return redirect("/item/{$item_id}");
    }
}
