@if (Auth::guard('admin')->check())
  <form action="{{ route('admin.messages.destroy', [$thread, $message->id]) }}" method="post" class="my-2">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('メッセージを削除します。本当によろしいでしょうか？')">削除</button>
  </form>
@else
@endif
