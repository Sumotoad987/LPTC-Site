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

?>