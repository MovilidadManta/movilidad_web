var socket = io.connect('http://192.168.0.100:8000', { 'forceNew': true, transport: ['websocket'], origins: '*:*' });

socket.on('enviar-correo', function(data) {
    //llenar_div_mensaje(data);
    console.log("mensaje del socket" + data)
    data.forEach(element => {
       
    });

    //$("#div-mensaje-chat-" + id_remitente).html(ht)
    //$("#div-mensaje-chat-" + id_remitente).scrollTop(1000000);
})