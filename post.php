<?php

class Logger
{
    public $log;

    function __construct()
    {
        $this->log = fopen("log.txt", "a");
    }

    function puts($mes)
    {
        fputs($this->log, $mes . "\n");
    }

    function __destruct()
    {
        fclose($this->log);
    }

}

$l = new Logger();

try {
    $pdo = new PDO("sqlite:sqlite.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS acc(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        accx NUMERIC,
        accy NUMERIC,
        accz NUMERIC,
        gaccx NUMERIC,
        gaccy NUMERIC,
        gaccz NUMERIC,
        rra NUMERIC,
        rrb NUMERIC,
        rrg NUMERIC,
        label VARCHAR(255),
        time INTEGER
    )");
    $data = json_decode($_POST["json"]);
    $stmt = $pdo->prepare("INSERT INTO acc(accx, accy, accz, gaccx, gaccy, gaccz, rra, rrb, rrg, label, time) VALUES(:accx, :accy, :accz, :gaccx, :gaccy, :gaccz, :rra, :rrb, :rrg, :label, :time)");


    //3回までリトライする
    for ($i = 0; $i < 3; $i++) {
        try {
            $pdo->beginTransaction();
            foreach ($data as $line) {
                $stmt->bindValue(":accx", $line->a->x);
                $stmt->bindValue(":accy", $line->a->y);
                $stmt->bindValue(":accz", $line->a->z);
                $stmt->bindValue(":gaccx", $line->g->x);
                $stmt->bindValue(":gaccy", $line->g->y);
                $stmt->bindValue(":gaccz", $line->g->z);
                $stmt->bindValue(":rra", $line->r->a);
                $stmt->bindValue(":rrb", $line->r->b);
                $stmt->bindValue(":rrg", $line->r->g);
                $stmt->bindValue(":label", $line->l);
                $stmt->bindValue(":time", $line->t);

                $stmt->execute();
            }
            $pdo->commit();
            break;
        } catch (PDOException $e) {
            $l->puts($e->getMessage());
            continue;
        }
    }

    echo "ok";
} catch (Exception $e) {
    $l->puts($e->getMessage());
}
