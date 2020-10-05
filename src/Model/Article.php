<?php


namespace App\Model;

use \PDO;
use \DateTime;

class Article extends BaseModel
{
    private int $id;
    protected string $title;
    protected string $content;
    protected DateTime $date;

    /**
     * @param bool $isNew (true if Save, false if Update)
     * @return bool
     */
    public function validate($isNew = true): bool
    {
        $isValid =
            !empty($this->title) &&
            !empty($this->content);

        return $isNew ? $isValid && empty($this->id) : !empty($this->id);
    }

    /**
     * @return int|string
     */
    public function create() : int
    {
        if (!$this->validate())
            throw new \InvalidArgumentException('Empty data');

        $sql = "INSERT INTO articles (title, content, date) VALUES (:title, :content, :date)";

        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(':title', $this->title);
        $smtp->bindParam(':content', $this->content);
        $date = (new DateTime())->format('Y-m-d H:i:s');
        $smtp->bindParam(':date', $date);

        $smtp->execute();

        $this->id = $this->pdo->lastInsertId();

        return $this->id;
    }

    public function update() : bool
    {
        if (!$this->validate(false))
            throw new \InvalidArgumentException('Error data for update');

        $sql = "UPDATE articles SET title=:title, content=:content WHERE id=:id";

        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(':title', $this->title);
        $smtp->bindParam(':content', $this->content);
        $smtp->bindParam(':id', $this->id);

        return $smtp->execute();
    }

    public function read(int $id = null)
    {
        if ($id) {
            $sql = "SELECT * FROM articles WHERE id=:id LIMIT 1";
            $smtp = $this->pdo->prepare($sql);
            $smtp->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM articles";
            $smtp = $this->pdo->prepare($sql);
        }
        $smtp->execute();

        return $id ? $smtp->fetch() : $smtp->fetchAll();
    }

    public function delete() : bool
    {
        $sql = "DELETE FROM articles WHERE id=:id";
        $smtp = $this->pdo->prepare($sql);
        $smtp->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $smtp->execute();
    }


    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }


}