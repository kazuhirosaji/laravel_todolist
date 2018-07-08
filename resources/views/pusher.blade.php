<!DOCTYPE html>
<html>
<head>
    <title>Pusher</title>
</head>
<body>
<input type="button" value="push" onclick='push()'>
<ul id="messages"></ul>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://js.pusher.com/3.1/pusher.min.js"></script>
<script>
    //Pusherキー
    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        encrypted: true,
        cluster: 'ap1'
    });

    //LaravelのEventクラスで設定したチャンネル名
    var channel = pusher.subscribe('my-channel');

    function addMessage(data) {
        console.log('addMessage');
        console.log(data.message);
        $('#messages').prepend(data.message + ' : ' + data.name);
    }

    function push(){
        console.log('push');
        $.get('/pusher');
    }

    //Laravelのクラス
    channel.bind('reference.event', addMessage);
    console.log(channel);

</script>
</body>
</html>