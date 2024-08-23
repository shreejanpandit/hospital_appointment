@if (session('status'))
    @php
        $status = session('status');
        $alertClass =
            $status['type'] === 'success'
                ? 'bg-green-100 border-green-400 text-green-700'
                : 'bg-red-100 border-red-400 text-red-700';
    @endphp

    <div class="alert {{ $alertClass }} border-l-4 p-4 m-4 rounded-lg relative" role="alert">
        <span class="font-bold">{{ $status['message'] }}</span>
    </div>
@endif
