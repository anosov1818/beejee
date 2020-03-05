<?php

class Model_Admin extends Model {

    public function get_auth_data() {
        $sql = "SELECT * FROM user";
        $sth = $this->pdo->query($sql);

        return $sth->fetchAll( PDO::FETCH_ASSOC );
    }

    public function get_tasks() {
        $sql = "SELECT * FROM task ORDER BY id ASC";
        $sth = $this->pdo->query($sql);

        return $sth->fetchAll( PDO::FETCH_ASSOC );
    }

    public function edit_task($id, $user_name, $email, $text, $status) {
        $sql = "UPDATE task SET user_name = ?, email = ?, text = ?, status = ? WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$user_name, $email, $text, $status, $id]);
    }

    public function edit_task_text($id, $text) {
        $sql = "UPDATE task SET text = ?, edit_by_admin = 1 WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([$text, $id]);
    }
}