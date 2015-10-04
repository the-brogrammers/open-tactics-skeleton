var gameServer = new GameServer({
    url: config.url,
    forceAjax: true
});

gameServer.on('open', function(data) {
    console.log('open', data);
});

gameServer.on('message', function(data) {
    console.log('message', data);
});

// Listen on custom channel
gameServer.on('time', function(data) {
    console.log('time', data);
});

gameServer.on('error', function(data) {

});

gameServer.connect();
