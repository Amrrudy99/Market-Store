<?php
	
	function lang( $phrase )
	{
      static $lang = array(

      		// Dashboard Page 
         //  Navbar Links
        
       'HomePage' => 'Home',
       'CATEGORIES' => 'Categories',
       'ITEMS'      => 'Items',
       'MEMBERS'    => 'Members',
       'COMMENTS'   => 'Comments',
       'STATISTICS' => 'Statistics',
       'LOGS'       => 'Logs',
       ''           => '',
       ''           => '',  
       ''           => '',

      );
     
     return $lang[$phrase];

	}