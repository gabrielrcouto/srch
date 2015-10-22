<?php
namespace Srch;

use Srch\Node;

class Tree
{
    protected $nodes = [];
    protected $root;

    public function __construct()
    {
        $this->root = new Node();
    }

    /**
     * Add items to the tree
     *
     * An item is like:
     *
     * [
     *     'id' => 1
     *     'fields' => [
     *         'name' => 'Hawaii',
     *         'sport' => 'Surf'
     *     ]
     * ]
     *
     * @param [Array] $items Array of items (array)
     */
    public function addItems($items)
    {
        foreach ($items as $key => $item) {
            $id = $item['id'];
            $fields = $item['fields'];

            foreach ($fields as $fieldName => $fieldValue) {
                //use the slug to normalize the text
                //we dont need accentuation or special chars
                $fieldValueWords = explode('-', Slug::generate($fieldValue]));

                foreach ($fieldValueWords as $word) {
                    $this->addWord($id, $fieldName, $word);
                }
            }
        }
    }

    public function addNode($base, $id, $field, $char)
    {
        if ($base->hasNode($char)) {
            $node = $base->getNode($char);
        } else {
            $node = new Node($char);
            $base->addChild($node);
        }

        $node->addField($field);
        $node->addItemId($itemId);

        return $node;
    }

    public function addWord($id, $field, $word)
    {
        $wordLength = strlen($word);
        $base = $this->root;

        for ($i = 0; $i < $wordLength; $i++) {
            $base = $this->addNode($base, $id, $field, $word[$i]);
        }
    }
}