@extends('layouts.app')

@section('content')
< div class='container' >
    <h1 > Thread: {
    {
        $thread->subject }
}</h1 >

    <div class='thread-body' >
        {
            {
                $thread->body }
        }
    </div >

    <div class='replies-container' >
@foreach ($thread->replies as $reply)
            <div class='reply' >
                {
                    {
                        $reply->body }
                }
            </div >
@endforeach
    </div >

    <form id = 'reply-form' >
    @csrf
        <div class='form-group' >
            <label for='body' > Reply</label >
            <div id = 'reply-editor' ></div >
            <input type = 'hidden' name = 'body' id = 'reply-body' required >
        </div >
        <button type = 'submit' class='btn btn-primary' > Post Reply </button >
    </form >
</div >

<script >
document . addEventListener('DOMContentLoaded', function () {
    var
    quill = new Quill('#reply-editor', {
        theme:
        'snow',
        });

        $('#reply-form') . on('submit', function (e) {
            e . preventDefault();

            // Get the content from the Quill editor
            var
            replyContent = quill . root . innerHTML;
            // Set the reply content in the hidden input field
            $('#reply-body') . val(replyContent);

            // Make an AJAX request to post the reply
            $.ajax({
                url: '{{ route('forum . storeReply', ['thread' => $thread->id]) }}',
                type: 'POST',
                data: $(this) . serialize(),
                success: function (response) {
                // Handle success - display the new reply
                $('.replies-container') . append('<div class="reply">' + response . message + '</div>');
                quill . root . innerHTML = ''; // Clear the editor
            },
                error: function (error) {
                // Handle error
            }
            });
        });
    });
</script >
@endsection
