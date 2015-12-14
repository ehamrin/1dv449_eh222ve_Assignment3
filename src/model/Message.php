<?php


namespace model;


class Message implements \JsonSerializable
{
    private $id;
    private $priority;
    private $created;
    private $title;
    private $location;
    private $description;
    private $latitude;
    private $longitude;
    private $category;
    private $subcategory;


    public function loadFromXML(\SimpleXMLElement $message){
        $this->id = (string) $message->attributes()["id"];
        $this->priority = (string) $message->attributes()["priority"];
        $this->created = (string) $message->createddate;
        $this->title = (string) $message->title;
        $this->location = (string) $message->exactlocation;
        $this->description = (string) $message->description;
        $this->latitude = (string) $message->latitude;
        $this->longitude = (string) $message->longitude;
        $this->category = (string) $message->category;
        $this->subcategory = (string) $message->subcategory;

        return $this;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    public function getCreated(){
        return $this->created;
    }
}