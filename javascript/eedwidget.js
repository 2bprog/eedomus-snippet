<script>

/*
function eedw_showPanel(PanelIdtoShow, PanelsClass)

masque des element en fonction d'un class
et affiche un element en fonction de son id
*/

function eedw_showPanel(PanelIdtoShow, PanelsClass) 
{
  var i;
  var x = document.getElementsByClassName(PanelsClass);
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(PanelIdtoShow).style.display = "block";  
}

/*

function setheight(totalHeight, headerHeight, mainElement, panelclass)

fixe la hauteur des elements en fonction de la hauteur d'une entete (optionnel)
(cela permet de mettre en place du scroll si les classes utilise overflow)
pour totalHeight utiliser visualViewport.height

*/
function eedw_setheight(totalHeight, headerHeight, mainElement, panelclass)
{

    document.body.style.height = totalHeight;
    if (mainElement !== null) mainElement.style.height = totalHeight;
    
    var i;
    var x = document.getElementsByClassName(panelclass);
    for (i = 0; i < x.length; i++) 
    {
        x[i].style.position  = "absolute";
        x[i].style.top = headerHeight;
        x[i].style.height = totalHeight - (headerHeight  + 2);
        x[i].style.width = "100%";
    }
}

/*
function eedw_adjustiframe(brequesturi)

ajustment de l'iframe en largeur à 100% 
ceci s'effectue avec une recherche sur l'url du widget
en php => $_SERVER['REQUEST_URI']
*/
function eedw_adjustiframe(brequesturi)
{
    if (window.parent !== null)
    {
        Array.prototype.forEach.call(window.parent.document.querySelectorAll("iframe"), 
        function(iframe) 
        {
            // recup iframe
            const url = new URL(iframe.src);
            var framesrc = url.pathname + url.search;
            if ( framesrc === brequesturi )
            {
                // trouvé => redimentionnement + sauvegarde de la hauteur
                iframe.style.width='100%';
                return;
              }
        });
    }
}

</script>