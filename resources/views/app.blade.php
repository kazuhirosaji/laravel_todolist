<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}"></script>

        <script>
            window.Laravel = {
                csrfToken: "{{ csrf_token() }}"
            };
        </script>
    </head>
    <body>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://js.pusher.com/3.1/pusher.min.js"></script>
        <div id="app">
            <navbar></navbar>
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
        <script>
            //Pusherキー
            // var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            //     encrypted: true,
            //     cluster: 'ap1'
            // });

            //LaravelのEventクラスで設定したチャンネル名
            // var channel = pusher.subscribe('my-channel');

            // function addMessage(data) {
            //     $('#messages').prepend(data.message['title'] + ' : ' + data.message['content']);
            // }

            //Laravelのクラス
            // channel.bind('reference.event', addMessage);
        </script>
    </body>
    <script src="{{ mix('js/app.js') }}"></script>
</html>