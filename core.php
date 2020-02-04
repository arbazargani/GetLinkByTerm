<?php

function CheckDestination($url) {

	if (@file_get_contents($url) === FALSE) {
		return FALSE;
	}

	return TRUE;
}


function DoJob ($url, $term = NULL) {
	// $url="http://srv.musictarin.com/Musics/dl/";

	$output = [];
	$data=file_get_contents($url);

	$data = strip_tags($data,"<a>");

	$d = preg_split("/<\/a>/",$data);
	foreach ( $d as $k=>$u ){
	    if( strpos($u, "<a href=") !== FALSE ) {
	    	if (!is_null($term)) {
	    		if( strpos($u, $term) !== FALSE ) {
	    			$u = preg_replace("/.*<a\s+href=\"/sm","",$u);
			        $u = preg_replace("/\".*/","",$u);
					$output[] = "<a href='" . "$url$u' download>" . $url . urldecode($u)."\r\n" . '</a><hr/>';
	    		}
	    	} else {
	    		$u = preg_replace("/.*<a\s+href=\"/sm","",$u);
		        $u = preg_replace("/\".*/","",$u);;
				$output[] = "<a href='" . "$url$u' download>" . $url . urldecode($u)."\r\n" . '</a><hr/>';
	    	}
	    }
	}
	return $output;
}