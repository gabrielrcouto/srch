--TEST--
Testing the entire engine with a portuguese dictionary
--FILE--
<?php
    require 'vendor/autoload.php';

    use Srch\Engine;

    //The sample data is a portuguese word dictionary
    $sampleData = explode("\n", file_get_contents(__DIR__ . '/../sample_data/pt_BR.dic'));

    $items = [
        [
            'id' => 0,
            'text' => 'portuguese'
        ]
    ];

    while (count($items) < 10000) {
        $randomIndex = rand(0, count($items));

        //The dictionary data has some words with "YYYY/XXXX"
        //We will slice it and get only the first part
        $text = explode('/', $sampleData[$randomIndex]);

        $items[] = [
            'id' => count($items),
            'text' => $text[0]
        ];
    }

    $engine = new Engine();

    //Build the graph to search on it
    $root = $engine->buildGraph($items);

    //Do the search!
    $results = $engine->search($root, 'portuguese');

    var_dump($results);
?>
--EXPECTF--
array(1) {
  [0]=>
  int(0)
}