<?
// --------------------------------------------------------------
//  eedstring
// --------------------------------------------------------------
// Auteur : Benjamin B. (Benj70b)
// Git	  : https://github.com/2bprog/eedomus-snippet
// --------------------------------------------------------------
// fonctions avec une orientation systeme
// --------------------------------------------------------------
// function sdk_syssleepms($ms)
// --------------------------------------------------------------

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