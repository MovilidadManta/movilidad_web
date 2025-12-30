//import express from 'express';
//var app = express();
//import server from 'http';
//server.Server(app);
import fetch from "node-fetch";

import cron from "node-cron";
//import result from "lodash";
/*.schedule("* * * * *", () => {
cron.schedule("* * * * * *", () => {
  //console.log(result)
  fetch('http://web.movilidadmanta.gob.ec/api/enviar-correo-happy-birthday')
  //fetch('http://192.168.0.250:8000/api/enviar-correo-happy-birthday')
    .then((respuesta) => {
      return respuesta.json()
    }).then((res) => {
      console.log(res);
      console.log('enviado');
    })
})*/

cron.schedule('30 00 * * *', () => {
  console.log('running a task every minute');
  fetch('http://movilidadmanta.gob.ec/api/enviar-correo-happy-birthday')
    //fetch('http://192.168.0.250:8000/api/enviar-correo-happy-birthday')
    .then((respuesta) => {
      return respuesta.json()
    }).then((res) => {
      console.log(res);
      console.log('enviado');
      var msg = 'Hello World';
      console.log(msg);
    })
});







