<?php
namespace Srch;

use Srch\Node;
use Srch\String\Slug;

class Engine
{
	public function addNode($root, $itemId, $char)
	{
		if ($root->hasNode($char)) {
			$node = $root->getNode($char);
		} else {
			$node = new Node($char);
			$root->addChild($node);
		}

		$node->addItemId($itemId);

		return $node;
	}

	public function buildGraph($items)
	{
		$root = new Node();

		//foreach item (id + text)
		foreach ($items as $key => $item) {
			//use the slug to normalize the text
			//we dont need accentuation or special chars
			$terms = explode('-', Slug::generate($item['text']));

			foreach ($terms as $term) {
				$length = strlen($term);
				$base = $root;

				for ($i=0; $i < $length; $i++) {
					$base = $this->addNode($base, $item['id'], $term[$i]);
				}
			}
		}

		return $root;
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