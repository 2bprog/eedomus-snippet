<?
// --------------------------------------------------------------
//  eedclientinfo
// --------------------------------------------------------------
// Auteur : Benjamin B. (Benj70b)
// Git	  : https://github.com/2bprog/eedomus-snippet
// --------------------------------------------------------------
// Information sur le type d'interface utilsé 
//
// exemple : 
//  $inf = new sdk_eedclientinfo($_SERVER, $_GET); 
//      
// --------------------------------------------------------------

class sdk_eedclientinfo
{
   
   private $_svars= array();
   private $_args = array();
   public $portail  = false;
   public $portailmobile  = false;
   public $portaillocal  = false;
   public $android  = false;
   public $ios  = false;
   public $inlocalnet  = false;
   public $darktheme = false;
   public $height = -1;

  // $svars  = $_SERVERS
  // $args = $_GET
    public function __construct($svars, $args)
    {
        $this->_svars =  $svars;
        $this->_args = $args;
        
        $host= $this->sdk_getvar('HTTP_HOST');
        $remote = $this->sdk_getvar('REMOTE_ADDR');
        $appmobile = $this->sdk_getarg('mode');
        $typemobile = $this->sdk_getarg('app');
        $this->darktheme  = $this->sdk_getarg('dark_theme') == '1';
        
        $this->height = $this->sdk_getarg('SMARTPHONE_HEIGHT');
        if ($this->height === '') $this->height = -1;
        
        // portail 'normal'
        $this->portail = strpos($host, 'secure.eedomus') !== false;
        if ($this->portail === false) 
        {
            // portail mobile
            $this->portailmobile = (strpos($host, 'm.eedomus.') !== false);
            if ($this->portailmobile === false)
            {
                // Appli android ?
                $this->android = ($appmobile == 'mobile') && ($typemobile == 'android');
                if ($this->android === false)
                {
                    // Appli IOS ?
                    $this->ios = ($appmobile == 'mobile') && ($typemobile == 'ios');
                }
            }
        }
        
        if ($this->portail === false &&  $this->portailmobile== false &&
            $this->android== false && $this->ios== false)
        {
            //  portail  local ?
            $this->portaillocal = $this->sdk_checkprivatenet($host);
            if ($this->portaillocal === false)
                $this->portail = true; // force portail car pas trouvé !
                
        }
        
        // client en local 
        $this->inlocalnet = $this->sdk_checkprivatenet($remote);
      
        
    }
    
   public function sdk_getvar($item)
   {
        $ret = '';
        if (isset($this->_svars[$item]))  $ret = strtolower($this->_svars[$item]);
        return $ret;
   }

   public function sdk_getarg($item)
   {
       $ret = '';
        if (isset($this->_args[$item]))  $ret = strtolower($this->_args[$item]);
        return $ret;
   }
      
   public function sdk_checkprivatenet($ip)
    {
        $ret = false;
        $nets = array ("127.0.0.1", "192.168.","172.16.", '10.', 'localhost');
        for ($i=17; $i <32; $i++)
        {
            $net[] = '172.'.$i.'.';
        }
        foreach ($nets as $net)
        {
            $ret = substr( $ip, 0, strlen($net) ) === $net;
            if ($ret === true) break;
        }
        return $ret;
    }
    
    public function sdk_dumpall()
    {
        echo "_svars : " ;       var_dump($this->_svars);
        echo "_args : ";        var_dump($this->_args);
        $this->sdk_dumpindic();
    }
    
    public function sdk_dumpindic()
    {
        echo "portail : ";          var_dump($this->portail);
        echo "portailmobile : ";    var_dump($this->portailmobile);
        echo "portaillocal : ";     var_dump($this->portaillocal);
        echo "android : ";          var_dump($this->android);
        echo "ios : ";              var_dump($this->ios);
		echo "darktheme : ";        var_dump($this->darktheme);
        echo "inlocalnet : ";       var_dump($this->inlocalnet);
        echo "height : ";        var_dump($this->height);
        
    }
    

}


?>