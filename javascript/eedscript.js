// ----------------------------------------------------------------------------
// function eedw_ScriptExec(url, doProxy, idctrl, api, fnresult )
// ----------------------------------------------------------------------------
// modification d'appel http pour utiliser ou pas la fonctionnalité du proxy eedomus
// avec optmisation de l'appel si on a le code api ou encore mieux l'id du controleur
// detection si on est directement sur la box
// ----------------------------------------------------------------------------
// url : url a executer
// doProxy : verification ou pas pour l'usage du proxy
// idctrl : identifiant du controleur (0 => utilsation du parametre api pour le recuperer)
// api    : periph_id pour recuperer le controleur si idctrl = 0
// fnresult : function (data) pour avoir le resultat de l'appel http
// ----------------------------------------------------------------------------
/* Exemple :
  var fnresult = function (data)
    {
        document.getElementById('tstresult').innerHTML = data;
    }
    fnresult('');
    
    url = 'http://localhost/script/?exec=2B_deconz.php&vars=[VAR1]&action=PUT&json={"on":true, "transitiontime":!TR!, "bri":!BRI!}&bri=[RAW_VALUE]&use=1,0&api=[VAR2]';
    
    var val = document.getElementById('tstnum').value;
    url = url.replace('[RAW_VALUE]', val.toString());
    url = url.replace('[VAR1]', '10.66.254.101:8090,FB5A4E6BBF,lights,12')
    url = url.replace('[VAR2]', '1810919,1810917')
    eedw_ScriptExec(url, true, 0, 1810919, fnresult);
*/
function eedw_ScriptExec(url, doProxy, idctrl, api, fnresult )
{

    var urlOrigin = new URL(url, 'http://localhost');    
    var isportail = (document.location.origin.search(".eedomus.com") != -1);
    
    var fnbox_http_query = function (url, idctrl, fnresult)
        {
            // appel de l'url sans traitement de redirection
            var d = new Date();
            var reqUrl = document.location.origin + '/box_http_query.php?controller_id='+ idctrl +'&from=script_proxy&url=' + encodeURIComponent(urlOrigin.href);
            eedw_doajax(reqUrl, true, fnresult);
        }

    // check proxy et on est sur eedomus.com
    if (isportail && doProxy)
    {
        if (idctrl == 0)
        {
            var urlconfig = "/config_select.php?controller_module_id=" + api;

            $.ajax({
              url: urlconfig,
              success: function(data) 
              {
                // recheche de l'id box dans le retour 
                var m = "\"controller_id\": ([^,]*),";                    
                var matches = data.match(m);
                if (matches != null)  idctrl = matches[1];
              },
              complete: function () 
                {                                  
                 if (idctrl != 0)
                    fnbox_http_query(urlOrigin, idctrl, fnresult) ;
                 else 
                 {
                   var newurl = document.location.origin + '/script_proxy/' + urlOrigin.search;
                   eedw_doajax(newurl, true, fnresult);
                 }
                }
            });
        }
        else
        {
            fnbox_http_query(urlOrigin, idctrl, fnresult);
        }
    }
    else
    {
        // local
        var newurl = document.location.origin + urlOrigin.pathname + urlOrigin.search ;
        eedw_doajax(newurl, false, fnresult)
    }
};


// ----------------------------------------------------------------------------
// eedw_doajax(url, checkredirection, fnresult)
// ----------------------------------------------------------------------------
// effectue un appel ajax avec traitment de la redirection eedomus au besoin
// ----------------------------------------------------------------------------
// url : url a executer
// checkredirection : verification ou pas de la redirection eedomus
// fnresult : function (data) pour avoir le resultat de l'appel http
// ----------------------------------------------------------------------------
function eedw_doajax(url, checkredirection, fnresult)
{
    var tmpResult = function (data)
    {
        
    }
    $.ajax({
    type: "GET",
    dataType: "text",
    crossDomain : true,
    url: url,
    success: function(data, textStatus) 
        {
            var docallresult = true;
            // si proxy => gestion de la redirection 
            if (checkredirection)
            {
				// extraction de l'url de refresh
                datatmp = data.toLowerCase();
                var m = "content=\"\\s*\\d+\\s*;\\s*url=(.*?)\\s*\">";                    
                var matches = datatmp.match(m);
                if (matches != null) 
				{
				    docallresult = false;
					// trouvé => on passe par  box_http_query.php
				    var redirurl = "/box_http_query.php/" + matches[1];
				    setTimeout(() =>    {   
				        eedw_doajax(redirurl, checkredirection, fnresult);
				    }, 100);

                }
            }

            if (docallresult === true)
            {
                if (fnresult !== null)  fnresult(data);
            }
        }
    });
};
        