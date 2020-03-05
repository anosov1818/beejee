<?php

class Model_Main extends Model {

    public function get_total_tasks() {
        $sql = "SELECT COUNT(*) FROM task";
        $sth = $this->pdo->query($sql);

        return $sth->fetchColumn();
    }

    public function get_tasks($sort, $direction, $limit, $offset) {
        $sql = "SELECT * FROM task ORDER BY $sort $direction LIMIT $limit OFFSET $offset";
        $sth = $this->pdo->query($sql);

        return $sth->fetchAll( PDO::FETCH_ASSOC );
    }

    public function add_task($user_name, $email, $text) {
        try {

            $sql = "INSERT INTO task (user_name, email, text, status) VALUES (?, ?, ?, 0)";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([$user_name, $email, $text]);

        } catch(Exception $e) {
            die('Ошибка базы данных: ' . $e->getMessage());
        }

        return TRUE;
    }
}
