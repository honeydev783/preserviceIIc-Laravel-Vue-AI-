<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $message)
      @if(Session::has('alert-' . $message))
      <p class="alert alert-{{ $message }}">{{ Session::get('alert-' . $message) }}</p>
      @endif
    @endforeach
  </div>