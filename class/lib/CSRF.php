<?php

// Borrowed from https://github.com/steveclifton/phpcsrftokens
// Modified, and implements suggestion from https://github.com/steveclifton/phpcsrftokens/issues/1

class CSRF
{

    protected static $cookieName = '_token';
    protected static $sessionName = '_token';

    /**
     * Generates a new token
     * @return object token
     */
    protected static function setNewToken(int $expiry)
    {

        $token = new \stdClass();
        $token->page = '/';
        $token->expiry = time() + $expiry;
        $token->sessiontoken = base64_encode(openssl_random_pseudo_bytes(32));
        $token->cookietoken = md5(base64_encode(openssl_random_pseudo_bytes(32)));

        setcookie(self::$cookieName, $token->cookietoken, $token->expiry);

        return $_SESSION[self::$sessionName] = $token;
    }

    /**
     * Returns a session token for a page
     * @return object token
     */
    protected static function getSessionToken()
    {
        $token = (isset($_SESSION[self::$sessionName]))?$_SESSION[self::$sessionName]:'';

        if (empty($token) || time() > (int) $token->expiry) {
            self::removeToken();
            $token = null;
        }

        return $token;
    }

    /**
     * Returns the token cookie value
     * @return string token string / empty string
     */
    protected static function getCookieToken(): string
    {
        return !empty($_COOKIE[self::$cookieName]) ? $_COOKIE[self::$cookieName] : '';
    }

    /**
     * Confirms that the superglobal $_SESSION exists
     * @return bool whether the session exists or not
     */
    protected static function confirmSessionStarted(): bool
    {
        if (!isset($_SESSION)) {
            trigger_error('Session has not been started.', E_USER_ERROR);
            return false;
        }

        return true;
    }

    /**
     * Returns a page's token.
     * - Page name is required so that users can browse to multiple pages and allows for each
     *   page to have its own unique token
     *
     * @param int $expiry time in seconds for token expiry
     * @return string markup to be used in the form
     */
    public static function getInputField(int $expiry = 1800): string
    {
        self::confirmSessionStarted();

        $token = (self::getSessionToken() ?? self::setNewToken($expiry));

        return '<input type="hidden" id="csrftoken" name="csrftoken" value="' . $token->sessiontoken . '">';
    }

    /**
     * Verify's a request token against a session token
     * @param bool whether to remove the token or not
     * @return bool whether the request submission is valid or not
     */
    public static function verifyToken($removeToken = false): bool
    {
        self::confirmSessionStarted();

        // if the request token has not been passed, check POST
        $requestToken = $_POST['csrftoken'];

        if (empty($requestToken)) {
            trigger_error('Token is missing', E_USER_WARNING);
            return false;
        }

        $token = self::getSessionToken();

        // if the time is greater than the expiry form submission window
        if (empty($token) || time() > (int) $token->expiry) {
            self::removeToken();
            return false;
        }

        // check the hash matches the Session / Cookie
        $sessionConfirm = hash_equals($token->sessiontoken, $requestToken);
        $cookieConfirm = hash_equals($token->cookietoken, self::getCookieToken());

        // remove the token
        if ($removeToken) {
            self::removeToken();
        }

        // both session and cookie match
        if ($sessionConfirm && $cookieConfirm) {
            return true;
        }

        return false;
    }

    /**
     * Removes a token from the session
     * @param string $page page name
     * @return bool successfully removed or not
     */
    public static function removeToken(): bool
    {
        self::confirmSessionStarted();

        unset($_COOKIE[self::$cookieName], $_SESSION[self::$sessionName]);

        return true;
    }
}
