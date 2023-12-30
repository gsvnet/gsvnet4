<?php

namespace App\Http\Requests;

use GSVnet\Forum\Threads\ThreadRepository;
use GSVnet\Forum\VisibilityLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check that user has permission to view the thread that is being replied to
        $threads = app(ThreadRepository::class);
        $thread = $threads->requireBySlug($this->threadSlug);

        if ($thread->visibility == VisibilityLevel::PRIVATE && Gate::denies('threads.show-private'))
            return false;

        if ($thread->visibility == VisibilityLevel::INTERNAL && Gate::denies('threads.show-internal'))
            return false;
        
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
            'body' => 'required',
            'threadSlug' => 'exists:forum_threads,slug'
        ];
    }
}
