<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var PUSHER_APP_KEY = "asldkfjs"
    var pusher = new Pusher(PUSHER_APP_KEY, {
      cluster: 'mt1',
      forceTLS: false
    });

    var channel = pusher.subscribe('mi-canal');
    channel.bind('mi-evento', function(data) {
      // alert(JSON.stringify(data));
      console.log(data.data)
      const message = data.data
      var node = document.createElement("LI");
      var textnode = document.createTextNode(message.user+"=>"+message.message);
      node.appendChild(textnode);
      document.getElementById("myList").appendChild(node);

    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Intenta publicar un evento en el canal <code>mi-canal</code>
    con nombre del evento <code>mi-evento</code>.
  </p>

  <ul id="myList">
    <li>Primer mensaje</li>
  </ul>

</body>