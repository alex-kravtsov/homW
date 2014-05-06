<?php

define("HOMW_BASE_PATH", dirname(__FILE__) );

require_once HOMW_BASE_PATH . '/config/config.php';
require_once HOMW_BASE_PATH . '/models/objects.php';

try {

  if(!date_default_timezone_set(homwConfig::TIMEZONE) ) throw new Exception("Invalid timezone identifier.");

  if(!mb_internal_encoding(homwConfig::INTERNAL_ENCODING) ) throw new Exception("Cannot set internal encoding.");

  if(!mb_regex_encoding(homwConfig::INTERNAL_ENCODING) ) throw new Exception("Cannot set regex encoding.");

  $model = new homwObjects();

  $model->load(homwConfig::SOURCE_XML);

  $objects = $model->getObjects();

  $articles = array();

  foreach($objects as $object){

    $article = new stdClass();

    $article->title = 'Объект недвижимости ' . $object->id;

    $article->alias = 'objekt-nedvizhimosti-' . $object->id;

    if(!ob_start() ) throw new Exception("Cannot start output buffering.");

    require HOMW_BASE_PATH . '/templates/default.html.php';

    $article->content = ob_get_clean();

    $articles[] = $article;

  }

  $category_title = "Категория для импорта объектов недвижимости";

  $category_alias = "kategorija-dlja-importa-objektov-nedvizhimosti";

  $category_description = "Категория для импорта объектов недвижимости";

  $table_prefix = homwConfig::TABLE_PREFIX;

  if(!ob_start() ) throw new Exception("Cannot start output buffering.");

  require_once HOMW_BASE_PATH . '/templates/default.sql.php';

  $output = ob_get_clean();

  file_put_contents(homwConfig::OUTPUT_SQL, $output);

}
catch(Exception $e){
  echo "Error:\n";
  echo "Message: " . $e->getMessage() . "\n";
  echo "File: " . $e->getFile() . "\n";
  echo "Line: " . $e->getLine() . "\n";
  echo "Trace:\n";
  echo $e->getTraceAsString() . "\n";
}
