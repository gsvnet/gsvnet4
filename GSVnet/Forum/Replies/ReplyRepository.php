<?php namespace GSVnet\Forum\Replies;

use App\Models\Reply;
use App\Models\User;
use GSVnet\Core\EloquentRepository;

class ReplyRepository extends EloquentRepository
{
    public function __construct(Reply $model)
    {
        $this->model = $model;
    }

    /**
     * Add `$user` as a liker of `$reply`.
     */
    public function like(User $user, Reply $reply)
    {
        $reply->likers()->save($user);
    }

    /**
     * Remove `$user` as a liker of `$reply`.
     */
    public function dislike(User $user, Reply $reply) 
    {
        $reply->likers()->where('user_id', $user->id)->delete();
    }

    /**
     * Check whether the user likes the reply.
     */
    public function userLikesReply(User $user, Reply $reply): bool {
        // 0 or 1
        $count = $reply->likers()->where('user_id', $user->id)->count();
        
        return $count == 1;
    }

    public function incrementLikeCount($replyId)
    {
        $this->model->where('id', $replyId)->increment('like_count');
    }

    public function decrementLikeCount($replyId)
    {
        $this->model->where('id', $replyId)->decrement('like_count');
    }
}