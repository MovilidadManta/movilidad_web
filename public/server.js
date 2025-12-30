/*const http = require('http');

const hostname = '127.0.0.1';
const port = 3000;

const server = http.createServer((req, res) => {
  res.statusCode = 200;
  res.setHeader('Content-Type', 'text/plain');
  res.end('Hello World! Welcome2 to Node.js');
});

server.listen(port, hostname, () => {
  console.log(`Server running at http://${hostname}:${port}/`);
});

// server-express.js
const express = require('express')
const app = express() // initialize app
const port = 3000

// GET callback function returns a response message
app.get('/', (req, res) => {
res.send('Hello World! Welcome to Node.js')
})

app.listen(port, () => {
console.log(`Server listening at http://localhost:${port}`)
})
*/
import express from 'express';
var app = express();
import server from 'http';
server.Server(app);
//var io = require('socket.io')(server);
/*var io = require('socket.io')(server, {
  cors: {
    origin: "*",
    credentials: true
  }
});*/
import fetch from "node-fetch";

/*import pg from 'pg';
const Client = pg.Client;

const ObtenerCorreo = async () => {

  const client = new Client({
    user: "postgres",
    host: "164.92.149.114",
    database: "db_movilidad",
    password: "admin",
    port: "5432"
  });

  await client.connect();
  const res = await client.query("select * from tbl_usuarios");
  const result = res.rows;
  await client.end();
  //io.emit('enviar-correo', result)
  return result;
}*/

import cron from "node-cron";
import result from "lodash";
cron.schedule("18 21 * * *", () => {
//cron.schedule("25 11 * * *", () => {
  //console.log(result)
  fetch('http://sgi.movilidadmanta.gob.ec/api/enviar-correo-happy-birthday')
  //fetch('http://192.168.0.102:8000/api/enviar-correo-happy-birthday')
    .then((respuesta) => {
      return respuesta.json()
    }).then((res) => {
      console.log(res);
      console.log('enviado');
    })
})



