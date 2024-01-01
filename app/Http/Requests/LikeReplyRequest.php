<?php

namespace App\Http\Requests;

use GSVnet\Forum\Replies\ReplyRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class LikeReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'reply' => 'required|exists:forum_replies,id'
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $replies = app(ReplyRepository::class);

                if ($replies->userLikesReply($this->user(), $this->reply)) {
                    $validator->errors()->add(
                        'userId',
                        'Al geliket.'
                    );
                }

                if ($this->reply->author_id == $this->user()->id) {
                    $validator->errors()->add(
                        'userId',
                        'Niet je eigen posts liken!'
                    );
                }
            }
        ];
    }
}
