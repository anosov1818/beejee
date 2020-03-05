<?php

class Controller_Admin extends Controller {

    public function action_index() {
        $this->model = new Model_Admin;

        if (!empty($_SESSION["logged_in"]))
            $data["logged_in"] = $_SESSION["logged_in"];
        else
            $data["logged_in"] = false;

        if (!empty($_SESSION["login_failed"])) {
            $data["login_failed"] = $_SESSION["login_failed"];
            unset($_SESSION["login_failed"]);
        }

        if ($_SESSION["logged_in"]) {
            $data["header_button_action"] = "/admin/logout";
            $data["header_button_text"] = "Выйти";
        } else {
            $data["header_button_action"] = "/admin";
            $data["header_button_text"] = "Авторизоваться";
        }

        $data["tasks"] = $this->model->get_tasks();

        foreach ($data["tasks"] as &$task) {
            if($task["status"])
                $task["status"] = "checked";
        }

        $this->view->generate('admin_view.php', 'template_view.php', $data);
    }

    public function action_login() {
        $this->model = new Model_Admin;

        if(isset($_POST['login']) && isset($_POST['password'])) {
            $login = $this->clean_var($_POST['login']);
            $password = $this->clean_var($_POST['password']);

            $auth_data = $this->model->get_auth_data();

            foreach ($auth_data as $data) {

                print_r($data);
                if($login === $data["login"] && $password === $data["password"]) {

                    $_SESSION['logged_in'] = true;

                } else {
                    $_SESSION['login_failed'] = true;
                }
            }
        }

        header('Location: /admin');
    }

    public function action_logout() {
        unset($_SESSION["logged_in"]);
        header('Location: /');
    }

    public function action_edit_task() {

        if(!$_SESSION["logged_in"])
            return NULL;

        $this->model = new Model_Admin;

        $id = $this->clean_var($_POST['id']);
        $user_name = $this->clean_var($_POST['user_name']);
        $email = $this->clean_var($_POST['email']);
        $text = $this->clean_var($_POST['text']);
        $status = $this->clean_var($_POST['status']);

        if(!empty($status))
            $status = 1;
        else
            $status = 0;

        $this->model->edit_task($id, $user_name, $email, $text, $status);

        header('Location: /admin');
    }

    public function action_edit_task_text() {
        if(!$_SESSION["logged_in"])
            return NULL;
        
        $this->model = new Model_Admin;

        $id = $this->clean_var($_POST['id']);
        $text = $this->clean_var($_POST['text']);

        $this->model->edit_task_text($id, $text);

        header('Location: /admin');
    }

    public function clean_var($value) {
        return htmlspecialchars(trim($value));
    }
}