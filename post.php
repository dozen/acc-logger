<?php

class Logger {
    public $log;

    function __construct() {
        $this->log = fopen("log.txt", "a");
    }

    function puts($mes) {
        fputs($this->log, $mes . "\n");
    }

    function __destruct() {
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
        time INTEGER
    )");

    $stmt = $pdo->prepare("INSERT INTO acc(accx, accy, accz, gaccx, gaccy, gaccz, rra, rrb, rrg, time) VALUES(:accx, :accy, :accz, :gaccx, :gaccy, :gaccz, :rra, :rrb, :rrg, :time)");

    $data = json_decode($_POST["json"]);

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
        $stmt->bindValue(":time", $line->t);

        $stmt->execute();
    }
    $pdo->commit();
} catch (Exception $e) {
    $l->puts($e->getMessage());
}
