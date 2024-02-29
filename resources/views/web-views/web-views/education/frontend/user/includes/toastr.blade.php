@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}')
        @endforeach
    </script>
@elseif(session('status'))
    <script>
        toastr.success('{{ session('status') }}')
    </script>
@elseif(session('resent'))
    <script>
        toastr.success('{{ \App\CPU\Helpers::translate(Link has been resend Successfully', 'alerts') }}')
    </script>
@endif
