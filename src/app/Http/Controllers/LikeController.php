<?php

namespace App\Http\Controllers;



class LikeController extends Controller
{

    public function likeItem($item_id)
    {
        $user = auth()->user();

        $user->likes()->toggle($item_id);


        return redirect("/item/{$item_id}");
    }
}
