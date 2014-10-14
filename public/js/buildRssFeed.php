<?php
// Used for the AJAX call from ajax.js to refresh the RSS feeds

if (!empty($_GET['url'])) {
	$url = $_GET['url'];
	$content = file_get_contents($url);
	$content = new SimpleXmlElement($content);

	$rssFeed = "";
	foreach ($content->channel->item as $item) {
		$rssFeed .= "<tr class='entry'><td><a href='".$item->link."' target='_blank'>".$item->title."</a></td></tr>";
	}

	echo $rssFeed;
}