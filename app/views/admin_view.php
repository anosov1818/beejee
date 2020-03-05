<?php if ($data["logged_in"]) { ?>
    <h1>Задачи</h1>
    <?php
    foreach ($data["tasks"] as $task) {

        echo "<form action=\"/admin/edit_task\" method=\"post\">
                <input type=\"hidden\" class=\"id\" name=\"id\" value=\"{$task["id"]}\">
              <div class=\"form-row align-items-center\">
                <div class=\"col-auto\">{$task["id"]}</div>
                <div class=\"col-auto\">
                  <input type=\"text\" class=\"form-control mb-2 user_name\" name=\"user_name\" placeholder=\"Имя пользователя\" value=\"{$task["user_name"]}\">
                </div>
                <div class=\"col-auto\">
                    <input type=\"text\" class=\"form-control mb-2 email\" name=\"email\" placeholder=\"Email\" value=\"{$task["email"]}\">
                </div>
                <div class=\"col-auto\">
                  <input type=\"text\" class=\"form-control mb-2 text\" name=\"text\" placeholder=\"Текст\" value=\"{$task["text"]}\">
                </div>
                <div class=\"col-auto\">
                  <div class=\"form-check mb-2\">
                    <input class=\"form-check-input status\" type=\"checkbox\" name=\"status\" {$task["status"]}>
                    <label class=\"form-check-label\" for=\"status\">
                      Выполнено
                    </label>
                  </div>
                </div>
                <div class=\"col-auto\">
                  <button type=\"submit\" class=\"btn btn-primary mb-2\">Сохранить</button>
                </div>
              </div>
            </form>";
    }
    ?>

    <?php if ($data['pages'] > 1) { ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="page-link" href="1" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Предыдущая</span>
                    </a>
                </li>
                <?php
                for ($i = 1; $i <= $data["pages"]; ++$i) {
                    if ($data["current_page"] == $i)
                        $style = "style=\"background:#e9ecef;\"";
                    else
                        $style = "";
                    echo
                    "<li class=\"page-item\">
                            <a class=\"page-link\" href=\"$i\" $style>$i</a>
                         </li>";
                }
                ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $data["last_page"];?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Следующая</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php } ?>

    <?php if ($data["success"]) {?>
        <div class="alert alert-success" role="alert">
            Задача успешно отредактирована!
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="login-form">
        <form action="/admin/login" method="post">
            <h2 class="text-center">Вход</h2>
            <div class="form-group">
                <input type="text" name="login" class="form-control" placeholder="Логин" required="required">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Пароль" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Войти</button>
            </div>
        </form>
        <?php if($data["login_failed"]) { ?>
            <div class="alert alert-danger" role="alert">
                Неверные логин или пароль.
            </div>
        <?php } ?>
    </div>
<?php } ?>