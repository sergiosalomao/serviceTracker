@extends('home')
@section('body')
    {{-- essa janela fecha assim que abre --}}
    <script>
        $(document).ready(function() {
            console.log('ok')

            setTimeout(function() {
                let new_window = open(location, '_self');
                new_window.close();

            }, 3000);

        });
    </script>
@endsection
