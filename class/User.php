<?php

require_once("lib/ActiveRecord.php");
require_once("lib/Database.php");
require_once("lib/Image.php");

// Remember to rename this to `User` before continuing, but retain the same column names.
// Feel free to delete this comment afterward.
class User extends Database implements ActiveRecord
{
    private static $dbName = 'marina';

    // Add your fields here that directly match the names of the columns in the owner table.
    protected $id;
	protected $username;
	protected $first_name;
	protected $last_name;
	protected $user_type;
	protected $password;
	protected $image;
	protected $address;
	protected $phone;
	
    // ...

    /**
     * Call the parent constructor to use a different database
     */
    function __construct()
    {
        parent::__construct(self::$dbName);
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
        $db = Database::getInstance(self::$dbName);
        return $db->fetch(
            'SELECT * FROM user WHERE id = ?;',
            [$id],
            'User'
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
        $db = Database::getInstance(self::$dbName);
        return $db->fetch(
            'SELECT * FROM user;',
            'User'
        );
    }
    /**
     * Find and return all resources
     *
     * @return ActiveRecord[]
     */
    public static function findAllByUser(int $created_by):array
    {
         // We call getInstance here because this is a static function
        $db = Database::getInstance(self::$dbName);
        return $db->fetchAll(
            'SELECT * FROM user where created_by=0 OR created_by=?;',
            [$created_by]
            );
        
    }
      /**
     * Find and return all resources
     *
     * @return ActiveRecord[]
     */
    public static function getAllOwners():array
    {
         // We call getInstance here because this is a static function
        $db = Database::getInstance(self::$dbName);
        return $db->fetchAll(
            'SELECT id,first_name,last_name FROM user where user_type=0;'
            );
        
    }
     /**
     * Get a resource by username
     *
     * @param string $username
     *
     * @throws UserNotFoundException
     */
    public static function getByUsername(string $username)
    {
        // Note: We call getInstance here because we're in a static function and can't use $this
        $user = Database::getInstance(self::$dbName)->fetch(
            'SELECT * FROM user WHERE username = ?;',
            [$username]
        );

        if (!$user) {
            throw new UserNotFoundException();
        }

        // We don't want the password to be returned
        unset($user->password);

        return $user;
    }
    /**
     * Creates a new resource and returns its id
     *
     * @return int
     */
    public function create(): int
    {
        // This function will create a minimal user with a hashed password but is not fully implemented.
        // You will need to augment this function to store all the other values!
        $username = $this->username;
        $password = $this->password;
		$fname = $this->first_name;
		$lname = $this->last_name;
		$address = $this->address;
		$phone = $this->phone;
		$user_type = $this->user_type;
		$image = $this->image;
        
            // Otherwise, create the user with the supplied password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            return $this->insert(
                'INSERT INTO user (username, password,first_name,last_name,address,phone,user_type,image,created_by)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?,?);',
                [$username, $hashedPassword,$fname,$lname,$address,$phone,$user_type,$image,$_SESSION['userId']]
            );
        
    }

    /**
     * Updates resource after calling its setters
     *
     * @return void
     */
    public function update():void
    {
        $id = $this->id;
        $first_name = $this->first_name;
        $last_name = $this->last_name;
        $image = $this->image;
        $user_type = $this->user_type;
        $address = $this->address;
		$phone = $this->phone;
         $this->fetch(
            'UPDATE user
            SET first_name = ?,
                last_name = ?,
                image = ?,
                user_type = ?,
                address=?,
                phone=?
            WHERE id = ?;',
            [$first_name, $last_name,$image, $user_type,$address ,$phone , $id]
        );
    }

    /**
     * Deletes resource by its id
     *
     * @return void
     */
    public function delete(): void
    {
         $id = $this->id;
        $this->fetch(
            'DELETE FROM user WHERE id = ?;',
            [$id]
        );
    }

    /**
     * Change a user's password in the database given a user id
     *
     * @param int $id The currently logged in user id
     * @param string $oldPassword The current password
     * @param string $newPassword The new password
     *
     * @return boolean true if successful, otherwise false.
     */
    public function changePassword(int $id, string $oldPassword, string $newPassword): bool
    {
        $user = $this->find($id);
        if (password_verify($oldPassword, $user->password)) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->fetch(
                'UPDATE user SET password = ? WHERE id = ?;',
                [$hashedNewPassword, $user->id]
            );
            return true;
        }

        return false;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $name
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }
    /*
    * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }
    /**
     * @return int
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param int $length
     */
    public function setUserType($UserType)
    {
        $this->user_type = $UserType;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param int $length
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
	/**
     * @return int
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param int $length
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
	/**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param int $length
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}
