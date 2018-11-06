@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert alert-dismissible
                    alert-{{ $message['level'] }}
                    {{ $message['important'] ? 'alert-important' : '' }}"
                    role="alert"
        >
            
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                >&times;</button>
            
            @if (is_array($message['message']))
                <ul>
                @foreach ($message['message'] as $msg)
                    <li>{!! $msg !!}</li>
                @endforeach
                </ul>
            @else
                {!! $message['message'] !!}
            @endif
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
