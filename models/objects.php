<?php

class homwObjects {

  private $objects = null;

  public function load($source_xml_file){

    $doc = new DOMDocument();

    $doc->load($source_xml_file);

    $node_list = $doc->getElementsByTagName('object');

    $this->objects = array();

    foreach($node_list as $node){

      $object = new stdClass();

      $object_id = $node->getElementsByTagName('id');
      $object->id = $object_id->item(0)->nodeValue;

      $object_oid = $node->getElementsByTagName('object_id');
      $object->object_id = $object_oid->item(0)->nodeValue;

      $object_district = $node->getElementsByTagName('district');
      $object->district = $object_district->item(0)->nodeValue;

      $object_rooms = $node->getElementsByTagName('rooms');
      $object->rooms = $object_rooms->item(0)->nodeValue;

      $object_square = $node->getElementsByTagName('square');
      $object->square = $object_square->item(0)->nodeValue;

      $object_floor = $node->getElementsByTagName('floor');
      $object->floor = $object_floor->item(0)->nodeValue;

      $object_price = $node->getElementsByTagName('price');
      $object->price = $object_price->item(0)->nodeValue;

      $object_price_per_metr = $node->getElementsByTagName('price_per_metr');

      if($object_price_per_metr->length == 0){
        $object->price_per_metr = '-';
      }
      else {
        $object->price_per_metr = $object_price_per_metr->item(0)->nodeValue;
      }

      $object_description = $node->getElementsByTagName('description');
      $object->description = $object_description->item(0)->nodeValue;

      $this->objects[] = $object;

    }

  }

  public function getObjects(){
    return $this->objects;
  }

}
