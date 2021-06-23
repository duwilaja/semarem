
var app = require('express')();
var http = require('http').createServer(app);
const io = require('socket.io')(http,{
      cors: {
        origin: "https://smartcity.matrik.co.id",
        methods: ["GET", "POST"],
        transports: ['websocket', 'polling'],
        credentials: true
    },
    allowEIO3: true
});
var connectedUsers = {};



app.get('/', function(req, res){
  res.sendFile(__dirname + '/notif.html');
});

io.on('connection', function(socket){
  console.log('a user connected');

  socket.on('chat message', function(msg){
    io.emit('chat message', msg);
    console.log(socket.id);
  });
  
  /*Register connected user*/
  socket.on('register',function(username){
    console.log('Resiter : '+username);
    socket.username = username;
    connectedUsers[username] = socket;
  });

  // Notifikasi
  socket.on('notif',function(data){
    const to = data.to,
     message = data.msg;
    if(connectedUsers.hasOwnProperty(to)){
        connectedUsers[to].emit('notif',{
            //The sender's username
            username : socket.username,
            //Message sent to receiver
            msg : message
        });
    }
  }); 

  socket.on('disconnect', function(){
    console.log('user disconnected');
  });

});

http.listen(3000, function(){
  console.log('listening on *:3000');
});
