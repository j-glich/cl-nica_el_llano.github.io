var contenido="";
function alertaError(msg){
  contenido+='<div id="alertjs" class="alert alert-danger alert-dismissible">';
  contenido+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
  contenido+='<h4><i class="icon fa fa-ban"></i>Ha Ocurrido un error </h4>'+msg;
  contenido+='</div>';
  $('#alerta').html(contenido);
  eliminar_alerta();
}
function alertaCorrecto(msg){
  contenido+='<div id="alertjs" class="alert alert-success alert-dismissible">';
  contenido+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
  contenido+='<h4><i class="icon fa fa-check"></i> Todo salió bien</h4>'+msg;
  contenido+='</div>';
  $('#alerta').html(contenido);
  eliminar_alerta();
}

function eliminar_alerta(){
  $('#alertjs').delay(4000).hide(600);
  $("body,html").animate({ // aplicamos la función animate a los tags body y html
      scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
    },700);

  //$('#alerta').empty();
  contenido="";
}
/*Funcion de los cambios cambia lo que esta en id=area*/
function form(url){

  $.ajax({
        url : url,
        dataType: "text",
        success : function (data) {
            $("#area").html(data);
        }
    });
  // console.log("Hola");

}


function confirmar(mensaje, url)
    {
    var mensaje;
    var opcion = confirm(mensaje);
    if (opcion == true) {
        form(url)
	} else {
	    alert("Se ha cancelado la operación");
	}
	
}

function accionesatributo(tipo, codigo){
  if(tipo=='D'){    
    confirmar("¿Confirmar eliminar atributo?",'../view/atributo/atributo.php?d='+codigo);
  }else if (tipo=='U') {
    form('../view/atributo/atributo.php?u='+codigo);
  }else if(tipo=='C'){
    form('../view/atributo/criterio.php?a='+codigo);
  }
}

function accionesCriterio(tipo, codigo){
  if(tipo =='D'){
    confirmar("¿Confirmar eliminar atributo",'../controller/CriteriosController.php?d='+codigo);
  }else if (tipo == 'U') {
    form('../view/atributo/formCriterio.php?a='+codigo);
  }
}




function sendForm(){
  $.ajax({
    method: "POST",
    dataType : "text",
    url: "../controller/ins.php?fr=a",
    data: $("#frmins").serialize(),
    success:function(data){
      alert("WAR");
      /*$("#area").html(data);
      if(data!=""){


      }*/
         console.log("valor devuelto: "+data);
        $('#crit').empty()
        $('#myModal').modal('toggle');
      $('#ok').show();
       $("#frmins")[0].reset();
      $('#ok').delay(4000).hide(600);
      $("body,html").animate({ // aplicamos la función animate a los tags body y html
          scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
        },700); //el valor 700 indica que lo ara en 700 mili segundos
      }
  });
  /*.done(function(msg){
    $('#ok').show();
    //$("#area").html(msg);
  });*/
}

function modiForm(){
  var msg = 'Si modifica los criterios para esta materia tendrá que volver a crear su guía de observación, ¿Desea Actualizar los criterios para esta materia?';
  if(confirm(msg)){
      sendForm(1);
  }else{
    alert('F');
  }
}

function show(){
  // console.log('click');

    $("#main-tab").css("display", "inline-block");

}

function showSecondTab(){
  $("#second-tab").css("display", "block");
}



var objeto= {};
var preguntas = new Array();
var valor = new Array();

function getQuestion(nombre){
preguntas.push(nombre);
  $("input[name='"+nombre+"']").each(function() {
    if($(this).val()!=""){

       preguntas.push($(this).val());


    }

  });
  $("input[name='valor"+nombre+"']").each(function(){
    if($(this).val()!=""){
      valor.push($(this).val());
    }
  });

  //preguntas.push(nombre);
  // var arr = JSON.stringify(preguntas);
  // // console.log(arr);
  if(preguntas.length>0){
    $( "#send" ).removeClass( "disabled" )
    $("#send").removeAttr("disabled");


    sendGO();
  }

  //$('#myModal').modal().hide();
  //setTimeout("$('.popup').hide();", 5000);
  // console.log(valor);
}

function sendGO(){
  var val = $("#asignatura").val();
  $.ajax({
          type: "POST",
          url: "../controller/guiaobservacion?p="+val,
          data: {'array': JSON.stringify(preguntas), 'valor': JSON.stringify(valor)},//capturo array
          success: function(data){
            $('#myModal').modal('toggle');
            preguntas=[];
            valor=[];
        }
});
 //$('#myModal').modal('toggle');
}

  function showPDF(){
    var val = $("#asignatura").val();
    var text = $('select[id="asignatura"] option:selected').text();
    //// console.log(text);
    window.open("../controller/guiaobservacion.php?f="+val+"&z="+text);
  //   $.ajax({
  //           type: "get",
  //           url: "../controller/guiaobservacion?f="+val,
  //           success: function(data){
  //             $("#area").html(data);
  //             // console.log('ok');
  //         }
  // });
  }

function saveGP(){
  var val = $("#asignatura").val();
  $.ajax({
          type: "POST",
          url: "../controller/guiaobservacion.php?p="+val,
          data: {'array': JSON.stringify(preguntas), 'valor': JSON.stringify(valor)},//capturo array
          success: function(data){
            $('#myModal').modal('toggle');
        }
});
 //$('#myModal').modal('toggle');
}

var asignatura = new Array();
var nombreasi = new Array();
var i = 0; //contador para asignar id al boton que borrara la fila
function goAsignatura(){
  $("#gotabla").show();
  var val = $("#asignatura").val();
  var a = $('select[id="asignatura"] option:selected').text();

  asignatura.push(val);
  //nombreasi.push(a);
  // console.log(" el valor es: "+asignatura);

  var fila = '<tr id="row' + i + '"><td>' + val + '</td><td>' + a + '</td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila

  i++;

  $('#mytable tr:last').after(fila);
    //$("#add").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
  $('button[name=remove]').click(function(){
    var id= $(this).attr("id");
    $('#row'+id).remove();
     asignatura[id]=0;
    // var index = asignatura.indexOf(nombre);
    // if (index > -1) {
    //    asignatura.splice(index, 1);
    // }
  });

}

function saveGOPI(){
  for (var j = 0; j < asignatura.length; j++) {
    if(asignatura[j]==0){
      asignatura.splice(j, 1);

    }
  }
  $.ajax({
    method: "POST",
    dataType : "text",
    url: "../controller/gointegradorcontroller?g=1",
    data: {   proyecto: $("#proyecto").val(),
      equipo:$("#equipo").val(),
      semestre:$("input:radio[name=semestre]:checked").val(),
      grupo: $("input:radio[name=grupo]:checked").val(),
      prueba:JSON.stringify(asignatura)},
    success:function(data){
      if(data==='ok'){
        alertaCorrecto("Se ha registrado el proyecto con éxito");
        $('#myModal').modal('toggle');
        asignatura=[];
      }else{
        alertaError("Error al registrar elproyecto. intentelo más tarde");
        $('#myModal').modal('toggle');
        asignatura=[];
      }
      /*$("#area").html(data);
      if(data!=""){


      }*/
        // console.log("valor devuelto: "+data);
        asignatura=[];
      // $('#ok').show();
      //  $("#frmins")[0].reset();
      // $('#ok').delay(4000).hide(600);
      // $("body,html").animate({ // aplicamos la función animate a los tags body y html
      //     scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
      //   },700); //el valor 700 indica que lo ara en 700 mili segundos
      }
  });
}

function evaluar_proyecto(p,s,g){
  $(document).ajaxStart(function() { Pace.restart(); });
  $.ajax({
    method: "GET",
    dataType : "text",
    url: "../view/atributo/evaluacion?p="+p,
    success:function(data){
      $("#area").html(data);
      /*if(data!=""){


      }*/
        // console.log("valor devuelto: "+data);
      // $('#ok').show();
      //  $("#frmins")[0].reset();
      // $('#ok').delay(4000).hide(600);
      // $("body,html").animate({ // aplicamos la función animate a los tags body y html
      //     scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
      //   },700); //el valor 700 indica que lo ara en 700 mili segundos
      }
  });
}

var pregunta = new Array();
var cali= new Array();
var obs= new Array();
function getEval(p,a){
  var i =0;
  $("input[name='"+p+"-"+a+"-pregunta']").each(function() {
    if($(this).val()!=""){
       pregunta.push($(this).val());
    }
  });
  $("#valor:checked").each(function() {
    if($(this).val()!=""){
       cali.push($(this).val());
    }
  });
  $("input[name='"+p+"-"+a+"-observacion']").each(function() {
    if($(this).val()!=""){
       obs.push($(this).val());
    }else{
      obs.push("NA");
    }
  });

  // console.log('id pregunta: '+pregunta);
  // console.log('calificacion: '+ cali);
  // console.log('Observaciones: '+ obs);
  //JSON.stringify(preguntas)

  $.ajax({
      type: "POST",
      url: "../controller/Evaluacion?pr="+p,
      data: {
        'preguntas': JSON.stringify(pregunta),
        'calificacion': JSON.stringify(cali),
        'observacion':JSON.stringify(obs)
        },//capturo array
      success: function(data){
        $('#myModal').modal('toggle');
        pregunta=[];
        cali=[];
        obs=[];
        //// console.log(data);
    }
  });

}

function proyeccion(pr,s,g){
  $.get("../controller/Proyeccion", {p: pr}, function(htmlexterno){
   $("#area").html(htmlexterno);
    		});
//  $("#area").load("../view/atributo/proyeccionProyecto?p="+pr);
  //$(document).ajaxStart(function() { Pace.restart(); });
  // $.ajax({
  //   method: "GET",
  //   dataType : "text",
  // //  url:"../public/bower_components/chart.js/samples/bar1.html",
  //   url: "../view/atributo/proyeccionProyecto?p="+p,
  //   success:function(data){
  //     $("#area").html(data);
  //     /*if(data!=""){


      //}*/
        //// console.log("valor devuelto: "+data);
      // $('#ok').show();
      //  $("#frmins")[0].reset();
      // $('#ok').delay(4000).hide(600);
      // $("body,html").animate({ // aplicamos la función animate a los tags body y html
      //     scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
      //   },700); //el valor 700 indica que lo ara en 700 mili segundos
  //     }
  // });
}

function guardaEvaluacion(equipo){
  var info='Una vez guardada la evaluación ya no podra volver a evaluar éste  proyecto ni poder modificar su evaluecion.  ¿Desea guardar la evaluación?';
  if (confirm(info)) {
    cambiaEvaluacion(equipo);
  } else {
    alert('No has aceptado la evaluación');
  }
}

function cambiaEvaluacion(equipo){
  $.ajax({
      type: "POST",
      dataType : "text",
      url: "../controller/Evaluacion?e="+equipo,
      success: function(data){
        if(data === 'ok'){
          $('#myModal').modal('toggle');
          alertaCorrecto('Evaluación guardada con éxito');
        }else{
          $('#myModal').modal('toggle');
          alertaError('Error al guardar la evaluación intentelo más tarde');
        }


        //// console.log(data);
    }
  });
}



 
