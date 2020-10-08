<?php


namespace App\Service;

use Psr\Container\ContainerInterface;

class SessionStorage implements StorageInterface
{
    protected string $sessionName;
    protected int $lifetime;
    protected string $path;
    protected string $domain;
    protected bool $security;
    protected bool $httpOnly;
    protected string $id;

    /**
     * Session constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->sessionName = /* $container->has('app_name') ? $container->get('app_name') : */
            'Private';
        $this->lifetime = 0;
        $this->path = '/';
        $this->domain = '';
        $this->security = false;
        $this->httpOnly = true;

        $this->start();
    }


    /**
     * Start session
     */
    private function start()
    {
        session_set_cookie_params(
            $this->lifetime, $this->path, null,
            $this->security, $this->httpOnly,
        );
        session_name($this->sessionName);
        session_start();
        $this->id = session_id();
    }

    /**
     * @param string $sessionName
     */
    public function setSessionName(string $sessionName): void
    {
        $this->sessionName = $sessionName;
    }

    /**
     * @param int $lifetime
     */
    public function setLifetime(int $lifetime): void
    {
        $this->lifetime = $lifetime;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @param bool $security
     */
    public function setSecurity(bool $security): void
    {
        $this->security = $security;
    }

    /**
     * @param bool $httpOnly
     */
    public function setHttpOnly(bool $httpOnly): void
    {
        $this->httpOnly = $httpOnly;
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
     * @return bool
     */
    public function isEmpty()
    {
        return empty($_SESSION);
    }

    /**
     * Returns the contents of storage
     * @param string|null $key
     * @return array|mixed|null
     */
    public function read($key = null)
    {
        if ($this->isEmpty())
            return null;

        if ($key && $this->hasKey($key)) {
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
     *
     */
    public function clear()
    {
        if (!$this->isEmpty())
            foreach ($_SESSION as $key => $value)
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