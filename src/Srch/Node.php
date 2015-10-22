<?php
namespace Srch;

class Node
{
	protected $char;
	protected $children;
	protected $ids;
	protected $fields;

	public function __construct($char = '')
	{
		if (! empty($char)) {
			$this->char = $char;
		}

		$this->children = [];
		$this->ids = [];
		$this->fields = [];
	}

	public function addChild($node)
	{
		$this->children[] = $node;
	}

	public function addField($field)
	{
		if (! $this->hasField($field)) {
			$this->fields[] = $field;
		}
	}

	public function addItemId($itemId)
	{
		if (! in_array($itemId, $this->ids)) {
			$this->ids[] = $itemId;
		}
	}

	public function getItemsId()
	{
		return $this->ids;
	}

	public function getNode($char)
	{
		foreach ($this->children as $child) {
			if ($child->isChar($char)) {
				return $child;
			}
		}

		return null;
	}

	public function getChildren()
	{
		return $this->children;
	}

	public function isChar($char)
	{
		return $this->char == $char;
	}

	public function hasChildren()
	{
		return count($this->children) > 0;
	}

	public function hasField($field)
	{
		return in_array($field, $this->fields);
	}

	public function hasNode($char)
	{
		foreach ($this->children as $child) {
			if ($child->isChar($char)) {
				return true;
			}
		}

		return false;
	}
}