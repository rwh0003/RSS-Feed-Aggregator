<?php

class Application_Form_Feed extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post');

		$this->addElement('text', 'name', array(
    		'label'		 => 'Enter the name of the RSS feed:',
    		'required'	 => true
    	));

    	$this->addElement('text', 'url', array(
    		'label'		=> 'Enter the RSS feed url:',
    		'required'	=> true
    	));

        $this->addElement('text', 'ttl', array(
            'label'      => 'Enter the total Time To Live (in seconds) for the feed (leave blank for infinite):',
            'required'   => false,
            'validators' => array(
                array('validator' => 'Int'))
        ));

    	$this->addElement('submit', 'submit');

    }


}