<?
// --------------------------------------------------------------
//  eedstring
// --------------------------------------------------------------
// Auteur : Benjamin B. (Benj70b)
// Git	  : https://github.com/2bprog/eedomus-snippet
// --------------------------------------------------------------
// fonctions pour la manipulation des chaines de caractères 
// --------------------------------------------------------------
// function sdk_strremoveifatend($source, $atend)
// function sdk_strafter ($this, $inthat)
// function sdk_strbefore ($this, $inthat)
// function sdk_strbetween ($this, $that, $inthat)
// --------------------------------------------------------------

function sdk_strremoveifatend($source, $atend)
{
    $ret = $source;
    if (substr($source,-strlen($atend))===$atend) 
        $ret = substr($source, 0, strlen($source)-strlen($atend));
    return $ret;
}

function sdk_strafter ($this, $inthat)
{
    return substr($inthat, strpos($inthat,$this)+strlen($this));
};


function sdk_strbefore ($this, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this));
};

function sdk_strbetween ($this, $that, $inthat)
{
    return sdk_strbefore ($that, sdk_strafter($this, $inthat));
};

?>