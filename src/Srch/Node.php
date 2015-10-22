<?php
namespace Srch;

class Node
{
	protected $char;
	protected $children;
	protected $ids;

	public function __construct($char = '')
	{
		if (! empty($char)) {
			$this->char = $char;
		}

		$this->children = [];
		$this->ids = [];
	}

	public function addChild($node)
	{
		$this->children[] = $node;
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