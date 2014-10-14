<?php

function checkIfValidRssFeed($url)
{
	$rssValidator = 'http://feedvalidator.org/check.cgi?url=';
    if($validationResponse = file_get_contents($rssValidator.urlencode($url)) ) {
        if(stristr($validationResponse , 'This is a valid RSS feed' ) !== false ) {
			return true;           
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function buildRssFeed($url)
{
	$mapper = new Application_Model_FeedMapper();
	$feed = new Application_Model_Feed();
    $mapper->find((int) $_POST['id'], $feed);

	$content = file_get_contents($feed->getUrl());
	$content = new SimpleXmlElement($content);

	$rssFeed = "";
	foreach ($content->channel->item as $item) {
		$rssFeed += "<tr class='entry'><td><a href='".$item->link."'>".$item->title."</a></td></tr>";
	}

	return $rssFeed;
}