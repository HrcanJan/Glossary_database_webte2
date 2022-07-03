<?php
class Word
{
    /* @var MyPDO */
    protected MyPDO $db;
    protected int $id;
    protected string $title;

    public function __construct(MyPDO $db)
    {
        $this->db = $db;
    }

/* @return int
*/
    public function getId(): int
    {
        return $this->id;
    }

/* @return string
*/
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }



    public function find($id)
    {
        $data = $this->db->run("SELECT * FROM word WHERE id = ?", [$id])->fetch();
        $this->id = $data['id'];
        $this->title = $data['title'];
    }

    public function save()
    {
        $this->db->run("INSERT INTO word(title) VALUES (?)", [$this->title])->fetch();
        $this->id = $this->db->lastInsertId(); //vrati id ktore bolo ako posledne vlozene
    }
}