<?php

class Application_Model_FeedMapper
{
	protected $_dbTable;

	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');			
		}
		$this->_dbTable = $dbTable;
		return $this;
	}

	public function getDbTable()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Application_Model_DbTable_FeedMapper');
		}
		return $this->_dbTable;
	}

	public function save(Application_Model_Feed $feed)
	{
		$data = array(
			'name'	=> $feed->getName(),
			'url'	=> $feed->getUrl(),
			'image' => $feed->getImage(),
			'ttl'	=> $feed->getTtl()
		);

		if (null === ($id = $feed->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}

	}

	public function find($id, Application_Model_Feed $feed)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$feed->setName($row->name)
			->setUrl($row->url)
			->setId($row->id)
			->setTtl($row->ttl)
			->setImage($row->image);
	}

	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		$entries = array();
		foreach($resultSet as $row) {
			$entry = new Application_Model_Feed();
			$entry->setName($row->name)
				->setUrl($row->url)
				->setId($row->id)
				->setTtl($row->ttl)
				->setImage($row->image);
				$entries[] = $entry;
		}
		return $entries;
	}

	public function delete($id)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$row->delete();
	}
}