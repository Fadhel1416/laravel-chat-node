var app = require('express')();
var server = require('http').Server(app);
const io = require("socket.io")(server, {
    cors: {
      origin: "http://127.0.0.1:8000",
      methods: ["GET", "POST"]
    }
  });
var redis = require('redis');
const cors = require('cors');
app.use(cors())
app.use(require('express').json())

app.options("*", cors()) 

server.listen(8890);
io.on('connection', function (socket) {
 
    console.log("client connected");
    var redisClient = redis.createClient();
    redisClient.subscribe('message');
 
    redisClient.on("message", function(channel, data) {
        socket.emit(channel, data);
    });
 
    socket.on('disconnect', function() {
        redisClient.quit();
    });
});