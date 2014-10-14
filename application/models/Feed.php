<?php

class Application_Model_Feed
{
	protected $_name;
	protected $_url;
	protected $_id;
	protected $_image;
	protected $_ttl;

	public function __construct(array $options = null)
	{
		if(is_array($options)) {
			$this->setOptions($options);
		}
	}

	public function __set($name, $url)
	{
		$method = 'set' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid feed property');
		}
		$this->$method($value);
	}

	public function __get($name)
	{
		$method = 'get' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid feed property');
		}
		$this->$method();
	}

	public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

	public function setName($name)
	{
		$this->_name = (string) $name;
		return $this;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function setUrl($url)
	{
		$this->_url = (string) $url;
		return $this;
	}

	public function getUrl()
	{
		return $this->_url;
	}

	public function setId($id)
	{
		$this->_id = (int) $id;
		return $this;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function setImage($image)
	{
		$this->_image = (string) $image;
		return $this;
	}

	public function getImage()
	{
		return $this->_image;
	}

	public function setTtl($ttl)
	{
		$this->_ttl = (int) $ttl;
		return $this;
	}

	public function getTtl()
	{
		return $this->_ttl;
	}
}