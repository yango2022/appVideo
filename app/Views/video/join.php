// app/Views/video/join.php
<!doctype html>
<html lang="pt-PT">
<head>
  <meta charset="utf-8">
  <title>Twilio Video — Test</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://sdk.twilio.com/js/video/releases/2.27.0/twilio-video.min.js"></script>
</head>
<body>
  <h1>Twilio Video — Entrar numa sala</h1>

  <form id="joinForm">
    <label>Identity: <input type="text" id="identity" name="identity" value="user_<?= substr(bin2hex(random_bytes(2)),0,6) ?>"></label><br>
    <label>Sala (room): <input type="text" id="room" name="room" value="sala-test"></label><br>
    <button type="submit">Entrar</button>
  </form>

  <div id="localMedia"></div>
  <div id="remoteMedia"></div>

  <script src="/js/video.js"></script>
</body>
</html>