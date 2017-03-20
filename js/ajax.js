dojo.require("dojox.json.schema");


$(document).ready(function (e) {
   $("#form").on('submit',(function(e) {     
        e.preventDefault();
        var bandera=false;
        var form = document.getElementById('form');
        var text = '{"year":'+'"'+
                    form["year"].value+'"'+
                    ',"album":'+'"'+
                    form["album"].value+'"'+
                    ',"category":'+'"'+
                    form["category"].value+'"'+
                    ',"uploadimage":'+'"'+
                    form["uploadImage"].value+'"'+                  
                    '}';      
        alert(text);
        console.log(text);
        arreglo = JSON.parse(text);                
        obj = arreglo;
        schema={          
                "properties" : {
                  "year": { "type" : "string", "pattern": "^([1-2])([0-9]){3}$"},
                  "album": { "type" : "string", "maxLength":150},
                  "category": { "type" : "string", "enum": ["rock","indie","reggae"]},          
                  "uploadimage": { "type" : "string", "maxLength":150}                  
                }
        };
        results = dojox.json.schema.validate(obj, schema);
        if(results.valid){
            bandera=true;
        }else{
            bandera=false;
            (results.errors).forEach( function(e){
              console.log(e.message);
            });
        }
       /*********************************************************/
       /* SI EL SCHEMA ES VALIDO SE HACE EL INSERT A LA BASE
       /*********************************************************/
       if(bandera==true){
            $.ajax({
               url: "./php/insertAlbum.php",
               type: "POST",
               data:  new FormData(this),
               contentType: false,
               cache: false,
               processData:false,               
               success: function(data){
                    if(data=='invalid file'){
                        alert("BD: ERROR AL INSERTAR EN LA BASE");                        
                    }else{                
                        cargarAlbums();        
                       // cargarTabla();                       
                    }                    
                },
                error: function(e){
                  alert("AJAX: ERROR EN PETICION AJAX");                    
                }          
              });
        }else{
          alert("DOJO: SCHEMA INSERT ALBUM NO VALIDO\n\nFORMATOS:\nAÑO: 3 DÍGITOS, PRIMER DÍGITO 1 Ó 2\nALBUM: 150 MÁXIMO CARACTERES\nCATEGORIA: ROCK, INDIE Ó REGGAE");
        }
     })
   );
});


function insertSong(){
    var bandera=false;
    var song = document.getElementById("song").value;
    var album = document.getElementById("selectAlbum").value;
    var duracion = document.getElementById("duracion").value;

    var dataString="album="+document.getElementById("selectAlbum").value+
                              "&song="+document.getElementById("song").value+       
                              "&duracion="+document.getElementById("duracion").value+                                                                 
                              "&insert="; 
    var text = '{"song":'+
                      '"'+song+'"'+','+
                      '"duracion":'+
                      '"'+duracion+'"'+
                      '}';  

    alert(text);
    console.log(text);
    arreglo = JSON.parse(text);                
    obj = arreglo;
    schema={          
            "properties" : {
              "song": { "type": "string", "maxLength":50},
              "duracion": { "type": "string", "pattern": "^([0-9]){2}:([0-9]){2}$"}              
            }
    };
    results = dojox.json.schema.validate(obj, schema);
    if(results.valid){
        bandera=true;
    }else{
        bandera=false;
        (results.errors).forEach( function(e){
          console.log(e.message);
        });
    }
    if(bandera==true){
        $.ajax({
            type: "POST",
            url: "./php/insertSong.php",
            data: dataString,
            crossDomain: true,
            cache: false,
            success: function(response) {
              alert(response);
               alert("EXITO AJAX: insertSong");
               cargarTabla();
            },
            error: function() {
                alert("ERROR AJAX: insertSong");
            }
       });      
    }else{
        alert("DOJO: SCHEMA INSERT SONG NO VALIDO\n\nCANCIÓN: MENOS DE 50 CARACTERES\nDURACIÓN: FORMATO MM:SS (EJ. 04:45, 03:20, 10:02)");
    }
} 


function cargarAlbums() {         
      $.ajax({
            type: "POST",
            url: "./php/cargarAlbums.php",
            data: "",
            crossDomain: true,
            cache: false,
            success: function(response) {                      
               document.getElementById("selectAlbum").innerHTML =response;    
               document.getElementById("selectXAlbum").innerHTML =response;              
            },
            error: function() {
                alert("ERROR AJAX: cargarAlbums");
            }
       });         
}
function cargarTabla(){
  var arreglo;
  var bandera=false;

  $.ajax({
        type: "POST",
        url: "./php/cargarTabla.php",
        data: "",
        crossDomain: true,
        cache: false,
        success: function(response) {                           
          document.getElementById("divXAlbum").style.display = "none";
          document.getElementById("divTodo").style.display = "inline";  
          alert(response);
          arreglo = JSON.parse(response);
          
          schema={          
                  "properties" : {
                    "ALBUM": { "type" : "string", "maxLength":150},
                    "CATEGORIA": { "type" : "string", "enum": ["rock","indie","reggae"]}, 
                    "YEAR": { "type" : "string", "pattern": "^([1-2])([0-9]){3}$"},
                    "RUTAIMAGEN": { "type" : "string", "maxLength":150},
                    "NOMBRE": { "type": "string", "maxLength":50},
                    "DURACION":{ "type": "string", "pattern":"^([0-9]){2}:([0-9]){2}$"}                                                                 
                  }
          };
          for(var i=0; i<arreglo.length; i++)
            results = dojox.json.schema.validate(arreglo[i], schema);

          if(results.valid){
              bandera=true;
              console.log("Todo salio bien en validacion esquema");
          }else{
              bandera=false;
              (results.errors).forEach( function(e){
                console.log(e.message);
              });
          }

          if(bandera==true){
              tabla="<table><thead><tr>"+
                      "<th>PORTADA</th>"+
                      "<th>ALBUM</th>"+
                      "<th>CATEGORÍA</th>"+
                      "<th>Año</th>"+ 
                      "<th>CANCIÓN</th>"+   
                      "<th>DURACIÓN</th>"+                    
                      "</tr></thead>";
              for (var i = 0; i < arreglo.length; i++) {
                    tabla +="<tbody><tr>"+
                    "<td><img src="+arreglo[i].RUTAIMAGEN+" width='100' height='100'></td>"+
                    "<td>"+arreglo[i].ALBUM+"</td>"+
                    "<td>"+arreglo[i].CATEGORIA+"</td>"+
                    "<td>"+arreglo[i].YEAR+"</td>"+
                    "<td>"+arreglo[i].NOMBRE+"</td>"+    
                    "<td>"+arreglo[i].DURACION+"</td>"+                
                    "</tr></tbody>";
              }
              tabla +="</table>";
              document.getElementById("tabla01").innerHTML=tabla;
          }else{
            console.log("El esquema de obtener datos es incorrecto");
          }

        },
        error: function() {
            alert("ERROR AJAX: cargarTabla");
        }
   });
}


function cargarPorAlbum(){
  $.ajax({
      type: "POST",
      url: "./php/cargarXAlbum.php",
      data: "",
      crossDomain: true,
      cache: false,
      success: function(response) {                                  
         document.getElementById("tablaXAlbum").innerHTML=response;
      },
      error: function() {
          alert("ERROR AJAX: cargarTabla");
      }
  }); 
}

function generarXML(){
  $.ajax({
      type: "POST",
      url: "./php/clienteXML.php",
      data: "",
      crossDomain: true,
      cache: false,
      success: function(response) {   
        alert(response);        

         xmlGuardar = response;         
         xmlRe = response.substr(39);          

         var respuesta = validarXML(xmlRe);         

         if(respuesta == true){       
            guardarXML(xmlGuardar);                    
         }
      },
      error: function() {
          alert("ERROR AJAX: generarXML");
      }
  }); 
}

function guardarXML(xml){
  var xmlAux = "xml="+xml+"&insert=";
  alert(xmlAux);
  $.ajax({
      type: "POST",
      url: "./php/guardarXML.php",
      data: xmlAux,
      crossDomain: true,
      cache: false,
      success: function(response) {   
        alert("Se guardo el XML"+response);
        leerXML(); 
      },
      error: function() {
          alert("ERROR AJAX: guardarXML");
      }
  }); 
}

function leerXML(){
  $.ajax({
      type: "POST",
      url: "./php/leerXML.php",
      data: "",
      crossDomain: true,
      cache: false,
      success: function(response) {
         document.getElementById("xml").innerHTML=response;
      },
      error: function() {
          alert("ERROR AJAX: leerXML");
      }
  }); 
}

function validarXML(xmlRe){
    var bandera = true;
    xml_str = xmlRe;
     var Module ={
          xml: xml_str,                  
          schema: '<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" elementFormDefault="qualified">'+
                  '<xs:element name="musica">'+
                    '<xs:complexType>'+
                      '<xs:sequence>'+
                        '<xs:element ref="cancion" maxOccurs="unbounded" minOccurs="0"/>'+
                      '</xs:sequence>'+
                    '</xs:complexType>'+
                  '</xs:element>'+
                  '<xs:simpleType name="Titulo">'+
                    '<xs:restriction base="xs:string">'+
                      '<xs:minLength value="1"/>'+
                      '<xs:maxLength  value="50"/>'+
                    '</xs:restriction>'+
                  '</xs:simpleType>'+
                  '<xs:simpleType name="restriccionAlbum">'+
                    '<xs:restriction base="xs:string">'+
                      '<xs:minLength value="1"/>'+
                      '<xs:maxLength  value="150"/>'+
                    '</xs:restriction>'+
                  '</xs:simpleType>'+
                  '<xs:complexType name="Album">'+
                    '<xs:simpleContent>'+
                      '<xs:extension base="restriccionAlbum">'+
                        '<xs:attribute name="categoria" type="Categoria"></xs:attribute>'+
                        '<xs:attribute name="year" type="Year"></xs:attribute>'+
                      '</xs:extension>'+
                    '</xs:simpleContent>'+
                  '</xs:complexType>'+
                  '<xs:simpleType name="Categoria">'+
                    '<xs:restriction base="xs:string">'+
                      '<xs:enumeration value="rock"/>'+
                      '<xs:enumeration value="indie"/>'+
                      '<xs:enumeration value="reggae"/>'+
                      '</xs:restriction>'+
                    '</xs:simpleType>'+
                  '<xs:simpleType name="Duracion">'+
                    '<xs:restriction base="xs:string">'+
                      '<xs:pattern value="([0-9]){2}:([0-9]){2}"/>'+
                    '</xs:restriction>'+
                  '</xs:simpleType>'+
                  '<xs:simpleType name="Year">'+
                    '<xs:restriction base="xs:string">'+
                      '<xs:pattern value="([1-2])([0-9]){3}"/>'+
                    '</xs:restriction>'+
                  '</xs:simpleType>'+
                  '<xs:annotation>'+
                    '<xs:documentation xml:lang="es"> Esta es mi documentacion </xs:documentation>'+
                  '</xs:annotation>'+
                  '<xs:complexType name="tipoSong">'+
                    '<xs:all>'+
                      '<xs:element name="titulo" type="Titulo"/>'+
                      '<xs:element name="album" type="Album"/>'+
                      '<xs:element name="duracion" type="Duracion"/>'+
                    '</xs:all>'+
                  '</xs:complexType>'+
                '<xs:element name="cancion" type="tipoSong"/>'+
            '</xs:schema>'
    };
    var validacion = xmllint.validateXML(Module);
    if (validacion.errors == null) {
      console.log("todo bien")
      bandera=true;
    }else{
      alert(validacion.errors);    
    }
    return(bandera);
}


function mostrarXAlbum(){
  document.getElementById("divXAlbum").style.display = "inline";
  document.getElementById("divTodo").style.display = "none";
}

function buscarXAlbum(){
  var dataString="album="+document.getElementById("selectXAlbum").value+                         
                  "&get="; 
          alert("IDalbum: "+dataString);
          $.ajax({
              type: "POST",
              url: "./php/buscarXAlbum.php",
              data: dataString,
              crossDomain: true,
              cache: false,
              success: function(response) {
                document.getElementById("TablaXAlbum").innerHTML=response;              
              },
              error: function() {
                  alert("ERROR AJAX: buscarTutor");
              }
         });  
}