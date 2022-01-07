<li class="media">
  <div class="media-body">
    <div class="media-heading mt-1 mb-1">
      <a class="text-dark" href="/questions/{{ $question->category->id }}/{{ $question->id }}/{{ $question->slug }}" title="{{ $question->title }}">
        {{ $question->title }}
      </a>
      <a class="float-right text-muted">
        <i class="far fa-clock"></i>
        <span class="timeago">{{ $question->updated_at->diffForHumans() }}</span>
      </a>
    </div>
  </div>
</li>
