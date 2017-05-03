<?php
	interface Session_share_implement {
	
		abstract public close ();
		abstract public destroy ( string $session_id );
		abstract public gc ( int $maxlifetime );
		abstract public open ( string $save_path , string $session_name );
		abstract public read ( string $session_id );
		abstract public write ( string $session_id , string $session_data );
	}
?>