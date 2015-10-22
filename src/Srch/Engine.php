<?php
namespace Srch;

use Srch\Node;
use Srch\String\Slug;

class Engine
{
	protected $tree;

	public function __construct($tree)
	{
		$this->tree = $tree;
	}

	public function search($node, $term, $allowedJumps = 0)
	{
		if (strlen($term) == 0) {
			return $node->getItemsId();
		}

		//run for each char
		$ids = [];
		$char = $term[0];

		$term = substr($term, 1, strlen($term));
		$length = strlen($term);

		if ($node->hasNode($char)) {
			$node = $node->getNode($char);
			return $this->search($node, $term, $allowedJumps);
		} else if ($allowedJumps > 0) {
			if ($length > 0) {
				$ids = [];

				foreach ($node->getChildren() as $childNode) {
					//can be:
					//more one char
					//less one char
					$ids = array_merge($ids, $this->search($childNode, $char . $term, $allowedJumps - 1));
					$ids = array_merge($ids, $this->search($childNode, $term, $allowedJumps - 1));
				}

				return $ids;
			} else {
				return $node->getItemsId();
			}
		}

		return [];
	}
}