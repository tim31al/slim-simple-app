<?php


namespace App\Service;

use Psr\Container\ContainerInterface;

class SessionStorage implements StorageInterface
{
    protected string $sessionName;
    protected string $id;

    /**
     * Session constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->sessionName = $container->get('app_name');
        $settings = $container->get('session');

        session_set_cookie_params(
            $settings['lifetime'], $settings['path'],
            $settings['domain'], $settings['security'],
            $settings['http_only']);

        session_name($this->sessionName);
        session_start();
        $this->id = session_id();
    }


    /**
     * Return session id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Returns true if and only if storage is empty
     *
     * @param null $key
     * @return bool
     */
    public function isEmpty($key = null)
    {
        if (null !== $key)
            return empty($_SESSION[$key]);

        return empty($_SESSION);
    }

    /**
     * Returns the contents of storage
     * @param string|null $key
     * @return array|mixed|null
     */
    public function read($key = null)
    {
        if ($this->isEmpty($key))
            return null;

        if (null !== $key && $this->hasKey($key)) {
            return $_SESSION[$key];
        }

        $data = [];
        foreach ($_SESSION as $key => $value) {
            $data[$key] = $value;
        }

        return $data;

    }

    /**
     * Writes $contents to storage
     *
     * @param $key
     * @param $value
     */
    public function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Clears contents from storage
     * @param $key
     */
    public function clear($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasKey($key)
    {
        return isset($_SESSION[$key]);
    }


}