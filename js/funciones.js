function ajax(url, datos, tipo_respuesta){
    //Variable de exito
    var exito;

    // Esta es la petición ajax que llevará
    // a la interfaz los datos pedidos
    $.ajax({
        url: url,
        data: datos,
        type: "POST",
        dataType: tipo_respuesta,
        async: false,
        success: function(respuesta){
            //Si la respuesta no es error
            if(respuesta){
                //Se almacena la respuesta como variable de éxito
                exito = respuesta;
            } else {
                //La variable de éxito será un mensaje de error
                exito = respuesta;
            } //If
        },//Success
        error: function(respuesta){
            //Variable de exito será mensaje de error de ajax
            exito = respuesta;
        }//Error
    });//Ajax

    //Se retorna la respuesta
    return exito;
}// ajax

/**
 * Carga la interfaz seleccionada
 * @param  {string} contenedor Nombre del contenedor donde se va a cargar
 * @param  {string} url        Url que va a cargar
 * @param  {array} datos      Datos a cargar
 * @return {void}
 */
function cargar_interfaz(contenedor, url, datos)
{
    // Carga de la interfaz
    $("#" + contenedor)/*.hide()*/.load(url, datos)/*.fadeIn('500')*/;
} // cargar_interfaz

function cerrar_modal()
{
    $('.ui-dialog').remove();
    $('#dialog-form').remove();
    $("#dialog-form").dialog("close");
    $("#dialog-confirm").dialog("close");
}


function imprimir(mensaje){
	//Se imprime el mensaje
 	console.log(mensaje);
}//Imprimir

function validar_campos_vacios(campos)
{
    //Variable contadora
    validacion = 0;

    //Recorrido para validar cada campo
    for (var i = 0; i < campos.length; i++){
        //validacion campo a campo
        if($.trim(campos[i]) != "") {
            validacion++;
        }
    };

    //Si todos los campos superan la validación
    if (validacion == campos.length) {
        //Retorna ok
        return true;
    } else {
        //Retorna falso
        return false;
    }

    //Se resetea la variable contadora
    validacion = 0;
}//validar_campos_vacios


function validar_campos_numericos(campos) {
    var validacion = 0;
    for (var i = 0; i < campos.length; i++) {
        if (parseFloat($.trim(campos[i])) != $.trim(campos[i])) {
            return false;
        }
    }
    return true;
}
