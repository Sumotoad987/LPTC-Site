<?php
date_default_timezone_set("Europe/Dublin"); 
function format_interval(DateInterval $interval) {
        $result = "";
        if ($interval->y) { $result .= $interval->format("%y years "); }
        else if ($interval->m) { $result .= $interval->format("%m months "); }
        else if ($interval->d) { $result .= $interval->format("%d days "); }
        else if ($interval->h) { $result .= $interval->format("%h hours "); }
        else if ($interval->i) { $result .= $interval->format("%i minutes "); }
        else if ($interval->s) { $result .= $interval->format("%s seconds "); }
    
        return $result;
}

function timeSince($date){
    $current = new DateTime(date('Y-m-d H:i:s'));
    $interval = $date->diff($current);
    return(format_interval($interval));
}

function insertActivity($connection, $name, $userid, $id, $type, $action){
	$stmt = $connection->prepare("Insert into Activity (Name, UserId, CorrespondingId, Type, Action) Values (?,?,?,?,?)");
	$stmt->bind_param("siiss", $name, $userid, $id, $type, $action);
	$stmt->execute();
	$stmt->close();
}

function rel2abs($rel, $base)
    {
        /* return if already absolute URL */
        if (parse_url($rel, PHP_URL_SCHEME) != '' || substr($rel, 0, 2) == '//') return $rel;

        /* queries and anchors */
        if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;

        /* parse base URL and convert to local variables:
         $scheme, $host, $path */
        extract(parse_url($base));

        /* remove non-directory element from path */
        $path = preg_replace('#/[^/]*$#', '', $path);

        /* destroy path if relative url points to root */
        if ($rel[0] == '/') $path = '';

        /* dirty absolute URL */
        $abs = "$host$path/$rel";

        /* replace '//' or '/./' or '/foo/../' with '/' */
        $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
        for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}

        /* absolute URL is ready! */
        return $abs;
}

function simpleRel2Abs($rel, $abs){
		$down = substr_count($rel, '../');
		$rel = str_replace("../", "", $rel);
		$returnPath = "";
		for($i = 0; $i<$down; $i++){
			$abs = implode('/', explode('/', $abs, -1));
			var_dump($abs);
		}
		return($abs . '/' . $rel);
	}

function userPermissons($rank, $connection){
	$stmt = $connection->prepare("Select Premissons From Ranks Where Id = ?");
	$stmt->bind_param("i", $rank);
	$stmt->execute();
	$stmt->bind_result($user_permissons);
	$stmt->fetch();
	$stmt->close();	
	return $user_permissons;
}

function getDissolved($premissons, $connection){
	$disolvedStmt = $connection->prepare("Select Name From Premissons Where Inherited = ?");
	for($i = 0; $i<count($premissons); $i++){
		$premissonName = $premissons[$i];
		$disolvedStmt->bind_param("s", $premissonName);
		$disolvedStmt->execute();				
		//The permissons that inherit from the one we are testing
		$disolvedStmt->bind_result($premisson);
		while($disolvedStmt->fetch()){
			$premissons[] = $premisson;
		}
	}
	return $premissons;
}

function areAuthorized($userRank, $requestedRank, $connection){
	#Get there premissons
	$userPremissons = userPermissons($userRank, $connection);
	$userPremissons = explode(",", $userPremissons);
	$userPremissons = getDissolved($userPremissons, $connection);
	#Get the premissons of the rank they are trying to set
	$rankPremissons = userPermissons($requestedRank, $connection);
	$rankPremissons = explode(",", $rankPremissons);
	$rankPremissons = getDissolved($rankPremissons, $connection);
	$differentPremissons = array_diff($rankPremissons, $userPremissons);
	if(count($differentPremissons) > 0){
		#Get the rank of the user they are trying to edit
		return false;
	}
	return true;
}

function rankName($rankId, $connection){
	$stmt = $connection->prepare("Select Name From Ranks Where id = ?");
	$stmt->bind_param("i", $rankId);
	$stmt->execute();
	$stmt->bind_result($rankName);
	$stmt->fetch();
	return($rankName);
}

function includeNoVars($path){
	//The vars used in the imported file are not accessible in this file
	include_once($path);
}

?>