const express = require('express');

const  app = express();

const server = require('http').createServer(app);

const io = require('socket.io')(server,  {
    cors: {origin:"*"}
});
io.on('connection',(socket)=>{
    console.log('connection');
    //Receiving
    socket.on('sendChatToServer', (message) => {
        console.log(message);

        //Show Message on both screen
        io.sockets.emit('sendChatToClient',message)
        //Show message to only receiver
        // socket.broadcast.emit('sendChatToClient', message);
    });

    socket.on('disconnect', (socket)=>{
       console.log('Disconnect');
    });
})

server.listen(3000,()=>{
   console.log('---- server is running -----')
});
