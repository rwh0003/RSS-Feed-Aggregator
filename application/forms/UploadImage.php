<?php

class Application_Form_UploadImage extends Zend_Form
{

    public function init()
    {
    	$this->setAttrib('enctype', 'multipart/form-data');
    	$this->setMethod('post');

        $description = "While many RSS feeds contain a picture, this one does not. You may upload a photo instead: ";
    	$file = new Zend_Form_Element_File('file');
		$file->setLabel($description)
		        ->setDestination(APPLICATION_PATH ."/../public/images")
				->addValidator('Count', false, 1)
				->addValidator('Size', false, 102400)
				->addValidator('Extension', false, 'jpg,png,gif');

		$this->addElement($file);

    	$this->addElement('submit', 'submit');
    }
}