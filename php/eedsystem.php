<?
// --------------------------------------------------------------
//  eedstring
// --------------------------------------------------------------
// Auteur : Benjamin B. (Benj70b)
// Git	  : https://github.com/2bprog/eedomus-snippet
// --------------------------------------------------------------
// fonctions avec une orientation systeme
// --------------------------------------------------------------
// function sdk_syscheckvalue($api,$val,$nbretry)
// function sdk_syssleepms($ms)
// --------------------------------------------------------------

function sdk_syscheckvalue($api,$val,$nbretry)
{
 
    $i=0;
    $nbretry = abs($nbretry);
    if ($nbretry > 10000) $nbretry = 10000;
    while ($i < $nbretry)
    {
        $i++;
        $valr = getvalue($api);
        usleep(10000);
        if ($valr['value'] == $val)  break;
    }        
    return $i < $nbretry;
}


function sdk_syssleepms($ms)
{
	$ms = abs($ms);
	if( $ms > 5000) $ms = 5000;
	for ($i = 0; $i < $ms ; $i++)
	{
		usleep(1000); //wait 1ms 
	}
}


?>