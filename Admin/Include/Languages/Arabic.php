<?php
	
	function lang( $phrase )
	{
      static $lang = array(
       'MESSAGE' => 'Welcome In Arabic',
       'ADMIN'   => 'Arabic Admin'

      );
     
     return $lang[$phrase];

	}