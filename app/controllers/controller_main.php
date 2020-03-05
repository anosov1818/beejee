<?php

class Controller_Main extends Controller {

    public $limit;
    public $offset;

    public function action_index() {
        $this->model = new Model_Main;

        $this->limit = 3;
        $total_tasks = $this->model->get_total_tasks();
        $total_pages = $this->get_total_pages($total_tasks, $this->limit);

        $_SESSION["current_page"] = !empty($_SESSION["current_page"]) ? $_SESSION["current_page"] : 1;
        $_SESSION["total_pages"] = $total_pages;

        $this->offset = ($_SESSION["current_page"] - 1)  * $this->limit;

        $data["tasks"] = $this->get_tasks();
        $data["pages"] = $total_pages;
        $data["current_page"] = $_SESSION["current_page"];
        $data["last_page"] = $total_pages;

        foreach ($data["tasks"] as &$task) {
            if ($task["status"] == 1) {
                $task["status"] = "Выполнено";
            } else {
                $task["status"] = "В работе";
            }

            if ($task["edit_by_admin"]) {
                $task["edit_by_admin"] = "<small><i>отредактировано администратором</i></small>";
            } else
                $task["edit_by_admin"] = "";
        }

        if ($_SESSION["logged_in"]) {
            $data["header_button_action"] = "/admin/logout";
            $data["header_button_text"] = "Выйти";
        } else {
            $data["header_button_action"] = "/admin";
            $data["header_button_text"] = "Авторизоваться";
        }

        if (isset($_SESSION["success"])) {
            $data["success"] = true;
            unset($_SESSION["success"]);
        }

		$this->view->generate('main_view.php', 'template_view.php', $data);
	}

	public function action_sort() {
	    $sort = $this->clean_var($_POST['sort']);

        $sort_parts = explode(" ", $sort);

        if (!empty($_SESSION["sort"]) && !empty($_SESSION["direction"])) {
            if ($_SESSION["sort"] == $sort_parts[0]) {
                $_SESSION["direction"] = $_SESSION["direction"] == "asc" ? "desc" : "asc";
                exit;
            }
        }

        $_SESSION["sort"] = $sort_parts[0];
        $_SESSION["direction"] = $sort_parts[1];

	    return NULL;
    }

    public function action_add_task() {
        $this->model = new Model_Main;

        $user_name = $this->clean_var($_POST['user_name']);
        $email = $this->clean_var($_POST['email']);
        $text = $this->clean_var($_POST['text']);

        $_SESSION["success"] = $this->model->add_task($user_name, $email, $text);

        header("Location: /");
        die();
    }

    public function action_set_current_page() {
        $current_page = $this->clean_var($_POST['currentPage']);

        $_SESSION["current_page"] = $current_page;
    }

    public function get_tasks() {
        if (empty($_SESSION["sort"]))
            $_SESSION["sort"] = "id";

        if (empty($_SESSION["direction"]))
            $_SESSION["direction"] = "ASC";

        $sort = strtoupper($_SESSION["sort"]);
        $direction = strtoupper($_SESSION["direction"]);

        return $this->model->get_tasks($sort, $direction, $this->limit, $this->offset);
    }

    public function get_total_pages($total_tasks, $limit) {
        return ceil($total_tasks / $limit);
    }

    /*public function action_success() {
        $this->view->generate('success_view.php', 'template_view.php');
    }*/

    public function clean_var($value) {
        return htmlspecialchars(trim($value));
    }
}