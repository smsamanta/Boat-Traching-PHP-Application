<?php

require_once('Database.php');
require_once('CSRF.php');
require_once('Exception.php');
require_once('class/lib/Image.php');

class Auth extends Database
{
    private static $dbName = 'marina';

    /**
     * Attempt to log the user into the system with the supplied username and
     * password. If successful, the method should set the users logged in status.
     *
     * @param string $username username of the user to be logged in
     * @param string $password unencrypted password
     *
     * @return boolean true if the username and password matched a record in the database, else false
     */
    public static function login($username, $password): bool
    {
        // Sanitize user input
        $sanitizedUsername = filter_var($username, FILTER_SANITIZE_EMAIL);

        try {
            // Lookup the user with the values we now have
            // Note: We call getInstance here because we're in a static function and can't use $this
            $user = Database::getInstance(self::$dbName)->fetch(
                'SELECT * FROM user WHERE username = ?;',
                [$sanitizedUsername]
            );

            if (!$user) {
                throw new UserNotFoundException();
            }
        } catch (UserNotFoundException $e) {
            // User doesn't exist, bail out
            return false;
        }

        // Validate the password entered matches the hashed password stored on the user
        if (password_verify($password, $user->password)) {
            // If we have the user object, lets put some information into the session
            $_SESSION['userId'] = $user->id;
            $_SESSION['isLoggedIn'] = true;
            return true;
        }

        return false;
    }
public static function register($post,$files): int
    {
        // Sanitize user input
        $sanitizedUsername = filter_var($post['username'], FILTER_SANITIZE_EMAIL);

        $username = $post['username'];
        $password = $post['password'];
        $fname    = $post['first_name'];
         $lname    = $post['last_name'];
         $address    = $post['address'];
         $phone    = $post['phone'];
         $user_type    = $post['user_type'];
         $photo    = '';
         if (isset($files["photo"]) && $files["photo"]["error"] == 0) {
            $image = new Image();
            $path = $image->upload($files["photo"]);
            if ($path != null) {
                 $photo    = $path;
                 

            } else {
                $photo    = '';
                
            }

        } 
         
		 // Otherwise, create the user with the supplied password
            $hashedPassword = password_hash($post['password'], PASSWORD_DEFAULT);
		   $insertid =  Database::getInstance(self::$dbName)->insert(
                'INSERT INTO user (username, password,first_name,last_name,address,phone,user_type,image,created_by)
                VALUES (?, ?,?, ?, ?, ?, ?, ?, ?);',
                [$username, $hashedPassword,$fname,$lname,$address,$phone,$user_type,$photo,1]
        );
           
            return count(Database::getInstance(self::$dbName)->fetch(
                'UPDATE  user SET created_by=? where id=?;',
                [$insertid, $insertid]
            ));
        
    }

    /**
     * Log the current user out of the system.
     */
    public static function logout()
    {
        unset($_SESSION['userId']);
        unset($_SESSION['isLoggedIn']);
        CSRF::removeToken('login');
        session_destroy();
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

}
