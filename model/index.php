<?php

require_once('Market.php');

$portifolio = new Market('estaticos_portfolio1.csv');

$market = new Market('estaticos_market_1.csv');

$market_matches = $portifolio->getMatches($market);

$market_matches->print();