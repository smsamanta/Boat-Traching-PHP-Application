<?php

require_once("lib/ActiveRecord.php");
require_once("lib/Database.php");
require_once("lib/Image.php");

class Boat extends Database implements ActiveRecord
{
    protected  $dbName;

    // These fields directly match the names of the columns in the Boat table.
    protected $id;
    protected $name;
    protected $reg_num;
    protected $length;
    protected $image;
    protected $owner_id;

    /**
     * Call the parent constructor to use a different database
     */
    function __construct()
    {
        $this->dbName = 'marina';
        parent::__construct($this->dbName);
    }
    
    /**
     * Find and return a single resource by its id
     *
     * @param int $id
     * @return ActiveRecord
     */
    public static function find(int $id): ActiveRecord
    {
        // We call getInstance here because this is a static function
        $db = Database::getInstance('marina');
        return $db->fetch(
            'SELECT * FROM boat WHERE id = ?;',
            [$id],
            'Boat'
        );
    }

    /**
     * Find and return all resources
     *
     * @return ActiveRecord[]
     */
    public static function findAll(): array
    {
        // We call getInstance here because this is a static function
        $db = Database::getInstance('marina');
        return $db->fetch(
            'SELECT * FROM boat;',
            'Boat'
        );
    }

    /**
     * Creates a new resource and returns its id
     *
     * @return int
     */
    public function create(): int
    {
        $name = $this->name;
        $reg_num = $this->reg_num;
        $length = $this->length;
        $image = $this->image;
        $owner_id = $this->owner_id;

        return $this->insert(
            "INSERT INTO boat (name, reg_num, length, image, owner_id,created_by)
            VALUES (?, ?, ?, ?, ?,?);",
            [$name, $reg_num, $length, $image, $owner_id,$_SESSION['userId']]
        );
    }
/**
     * Find and return all resources
     *
     * @return ActiveRecord[]
     */
    public static function findAllByUser(int $created_by)
    {
        //echo $this->dbName;
         // We call getInstance here because this is a static function
        $db = Database::getInstance('marina');
        return $db->fetchAll(
            'SELECT b.id,b.name,b.reg_num,b.length,b.image,concat(u.first_name,"",u.last_name) as owner FROM boat b,user u where b.owner_id=u.id AND b.created_by=?;',
            [$created_by]
            );
        
    }
    /**
     * Updates a resource after calling its setters
     *
     * @return void
     */
    public function update(): void
    {
        $id = $this->id;
        $name = $this->name;
        $reg_num = $this->reg_num;
        $length = $this->length;
        $image = $this->image;
        $owner_id = $this->owner_id;

        $this->fetch(
            'UPDATE boat
            SET name = ?,
                reg_num = ?,
                length = ?,
                image = ?,
                owner_id = ?
            WHERE id = ?;',
            [$name, $reg_num, $length, $image, $owner_id, $id]
        );
    }

    /**
     * Deletes a boat by its id
     *
     * @return void
     */
    public function delete(): void
    {
        $id = $this->id;
        $this->fetch(
            'DELETE FROM boat WHERE id = ?;',
            [$id]
        );
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getRegNum()
    {
        return $this->reg_num;
    }

    /**
     * @param int $reg_num
     */
    public function setRegNum($reg_num)
    {
        $this->reg_num = $reg_num;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        if (!$this->image) {
            return null;
        }
        $uploads_path = Image::$BASE_UPLOAD_PATH;
        return "{$uploads_path}{$this->image}";
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @param int $owner_id
     */
    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;
    }
}
