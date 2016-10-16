function valida(tipo,objecto, error, msg){
        retorno = "";
        switch(tipo){
            case "text":
                if ((objecto.val().replace(/^\s*|\s*$/g, '') !=''  ) && (objecto.val().length > 5)) {
                    objecto.css('background','#FFFFFF');
                } else {
                    alert(msg);
                    objecto.focus();
                    objecto.css('background','#FFE6D9');
                    jQuery("#"+error).html(msg).show('slow');
                    setTimeout("jQuery(\"#"+error+"\").fadeOut(\"slow\")", 8000);
                    retorno = "Error";
                }
                break;
            case "email":
                if ((objecto.val().match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/))) {
                    objecto.css('background','#FFFFFF');
                } else {
                    alert('Correo es inválido');
                    objecto.focus();
                    objecto.css('background','#FFE6D9');
                    jQuery("#"+error).html('Email inválido.').show("slow");
                    setTimeout("jQuery(\"#"+error+"\").fadeOut(\"slow\")", 4000);
                    retorno = "Error";
                }
                break;
            case "DNI":
                if ( (objecto.val().match(/[0-9]{8}/)) && (objecto.val().length == 8 )) {
                    objecto.css('background','#FFFFFF');
                } else {
                    alert(msg);
                    objecto.focus();
                    objecto.css('background','#FFE6D9');
                    jQuery("#"+error).html(msg).show("slow");
                    setTimeout("jQuery(\"#"+error+"\").fadeOut(\"slow\")", 4000);
                    retorno = "Error";
                }
                break;
            case "Telf":
                if ( (objecto.val().match(/[0-9]{7}/)) && (objecto.val().length > 6 )) {
                    objecto.css('background','#FFFFFF');
                } else {
                    alert(msg);
                    objecto.focus();
                    objecto.css('background','#FFE6D9');
                    jQuery("#"+error).html(msg).show("slow");
                    setTimeout("jQuery(\"#"+error+"\").fadeOut(\"slow\")", 4000);
                    retorno = "Error";
                }
                break;
        }
        return retorno;
    }