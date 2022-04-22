<form method="POST" action="{{ route('messages.store', $thread->id) }}" class="mb-4"
    enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="thread-first-content">内容</label>
        <textarea name="body" class="form-control" id="thread-first-content" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="message-images">画像</label>
        <input type="file" class="form-control-file" id="message-images" name="images[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary">書き込む</button>
</form>
