@extends('layouts.app')

<div class='containerss'style='height: 300px; width: 55%;position: absolute;top: 19%;left: 28%;'>
    <form method='POST' action="{{ route('forum.store') }}">
        @csrf
        <div class='form-groupss'>
            <label for='subject'>Titel</label>
            <input type='text' name='subject' class='form-control' id='subject'>
        </div>
        <div class='form-groupsss'>
            <label for='body'>Bericht</label>
            <div id='editor-container'>
                <div id='editor'></div>
            </div>
            <input type='hidden' name='body' id='body'>
        </div>
        <button type='submit' class='btn btn-primary'>Post Topic</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'image': 'image' }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        var form = document.querySelector('form');
        var subjectInput = document.querySelector('#subject');
        var bodyInput = document.querySelector('#body');

        form.addEventListener('submit', function (event) {
            var subject = subjectInput.value.trim();
            var body = quill.root.innerHTML.trim();

            // Log subject and body
            console.log('Subject:', subject);
            console.log('Body:', body);

            // Check if body is the default Quill message
            if (body === '<p><br></p>') {
                alert('Content must not be empty.');
                event.preventDefault();
            } else {
                bodyInput.value = body;
            }
        });
    });
</script>

