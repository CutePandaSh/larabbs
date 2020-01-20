<ul class="list-unstyled">

  @foreach ($replies as $reply)
    <li class="media" name="reply{{$reply->id}}" id="reply{{$reply->id}}">
      <div class="media-left">
        <a href="{{ route('users.show', $reply->user_id) }}">
          <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" style="width: 48px; height:48px;" class="media-object img-thumbnail mr-3">
        </a>
      </div>

      <div class="media-body">
        <div class="media-heading text-secondary mt-0 mb-1">
          <a href="{{ route('users.show', $reply->user_id) }}" title="{{ $reply->user->name }}">
            {{ $reply->user->name }}
          </a>
          <span class="text-secondary"> ∙ </span>
          <span class="meta text-secondary" title="{{ $reply->created_at }}">{{ $reply->created_at->diffforHumans() }}</span>

          @can('destroy', $reply)
          <span class="meta float-right">
            <form action="{{ route('replies.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('确定要删除此评论？');">
              {{ csrf_field() }}
              {{ method_field('DELETE')}}
              <button class="btn btn-default btn-xs pull-left text-secondary" type="submit">
                <i class="far fa-trash-alt"></i>
              </button>
            </form>
          </span>
          @endcan
        </div>

        <div class="reply-content text-secondary">
          {!! $reply->content !!}
        </div>

      </div>

    </li>

    @if (! $loop->last)
      <hr>
    @endif

  @endforeach

</ul>
