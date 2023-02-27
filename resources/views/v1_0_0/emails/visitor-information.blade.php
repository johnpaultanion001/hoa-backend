<html>

<body>
    <img src="{!!$message->embedData(QrCode::format('png')->generate($data['id']), 'QrCode.png', 'image/png')!!}">
</body>

</html>