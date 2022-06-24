@pushOnce('js')
    <script>
        // toast
        @if (session('status'))
            toast.success('{!! session('status') !!}')
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toast.error('{{ $error }}')
            @endforeach
        @endif
    </script>
@endPushOnce
