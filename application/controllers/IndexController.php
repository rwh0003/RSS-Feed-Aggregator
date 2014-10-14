<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $feed = new Application_Model_FeedMapper();
        $feeds = $feed->fetchAll();

        // array to be passed to the view
        $data = array();

        foreach ($feeds as $feed) {
        	$content = file_get_contents($feed->getUrl());
        	$content = new SimpleXmlElement($content);

        	$title = $content->channel->title;
            $link = $content->channel->link;
			$description = $content->channel->description;

            $entries = array();

            foreach ($content->channel->item as $item) {
                array_push($entries, "<tr class='entry'><td><a href='".$item->link."' target='_blank'>".$item->title."</a></td></tr>");
            }           

            // By default the image is blank unless the RSS feed provides one
            // or one is uploaded by the user.
            $img = "";
            if (!empty($content->channel->image)) {
                $img = $content->channel->image->url;
            } else if (!empty($feed->getImage())) {
                $img = "/images/". $feed->getImage();  
            }
            
        	array_push($data, array(
        		'name' => $feed->getName(),
        		'title' => $title,
                'feed-url' => $feed->getUrl(),
                'link' => $link,
        		'entries' => $entries,
        		'image' => $img,
                'ttl' => $feed->getTtl(),
        		'description' => $description,
        		'id' => $feed->getId()
        		));
        }

        $this->view->feeds = $data;
    }

    public function addFeedAction()
    {
    	$request = $this->getRequest();
    	$form = new Application_Form_Feed();

    	if ($this->getRequest()->isPost()) {
    		
    		if ($form->isValid($request->getPost())) {
    			$url = $_POST['url']; 

		        if(checkIfValidRssFeed($url)) {
		            $content = file_get_contents($url);
		        	$content = new SimpleXmlElement($content);

                    // If the RSS feed doesn't come with an image,
                    // take the user to the image upload form while
                    // saving all post data in a session
		        	if (empty($content->channel->image)) {
						$imgForm = new Application_Form_UploadImage();
						$this->view->form =	$imgForm;

						session_start();
						$_SESSION['name'] = $_POST['name'];
						$_SESSION['url'] = $_POST['url'];
                        $_SESSION['ttl'] = $_POST['ttl'];
			        	return $this->_helper->redirector('upload-image');

					} else {
			        	$feed = new Application_Model_Feed($form->getValues());
			        	$mapper = new Application_Model_FeedMapper();
			        	$mapper->save($feed);
			        	return $this->_helper->redirector('index');
					}
		        } else {
		            echo '<div style="color:red;">This is not a valid RSS feed!</div>';
                }
    		}
    	}
        
    	$this->view->form = $form;
    }

    public function uploadImageAction()
    {
    	$request = $this->getRequest();
		$form = new Application_Form_UploadImage();

		if ($this->getRequest()->isPost()) {
    		if ($form->isValid($request->getPost())) {		 
		        $form->file->receive();
		        $fileInfo = $form->file->getFileInfo();
		        
		        session_start();
		        $options = array(
		        	'name' 	=> $_SESSION['name'],
		        	'url' 	=> $_SESSION['url'],
		        	'image' => $fileInfo['file']['name']
		        	);
	        	
	        	$feed = new Application_Model_Feed($options);
	        	$mapper = new Application_Model_FeedMapper();
	        	$mapper->save($feed);
	        	return $this->_helper->redirector('index');

		    } else {
		    	echo '<div style="color:red;">This is not a valid image!</div>';
		    }
		}

    	$this->view->form = $form;
    }

    public function editFeedAction()
    {

    	$request = $this->getRequest();
    	$form = new Application_Form_Feed();
    	$imgForm = new Application_Form_UploadImage();

    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($request->getPost())) {
    			$url = $_POST['url']; 
		        if(checkIfValidRssFeed($url)) {
		        	$mapper = new Application_Model_FeedMapper();
		        	$feed = new Application_Model_Feed();
			        $mapper->find((int) $_POST['id'], $feed);

		        	$feed->setName($_POST['name']);
		        	$feed->setUrl($_POST['url']);
                    $feed->setTtl($_POST['ttl']);

		        	if (!empty($_POST['file'])) {
						$imgForm = new Application_Form_UploadImage();
						$imgForm->file->receive();
		        		$fileInfo = $imgForm->file->getFileInfo();
		        		$feed->setImage($fileInfo['file']['name']);
					}

		        	$mapper->save($feed);
		        	return $this->_helper->redirector('index');
    						
    			} else
    				echo '<div style="color:red;">This is not a valid RSS feed!</div>';
    		}
    	}

    	$mapper = new Application_Model_FeedMapper();
    	$feed = new Application_Model_Feed();
        $mapper->find((int) $this->getParam('id'), $feed);
        $this->view->feed = $feed;
    }

    public function deleteAction()
    {
    	$mapper = new Application_Model_FeedMapper();
    	$mapper->delete($this->getParam('id'));
		return $this->_helper->redirector('index');
    }
}