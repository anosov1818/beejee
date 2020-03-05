<h1>Приложение-задачник</h1>
<table id="tasks" class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col" class="user_name asc text-primary">Имя пользователя</th>
        <th scope="col" class="email asc text-primary">Email</th>
        <th scope="col">Текст задачи</th>
        <th scope="col" class="status asc text-primary">Статус</th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach ($data["tasks"] as $task) {
            echo
                "<tr>
                    <th scope=\"row\">" . $task["id"] . "</th>
                    <td>" . $task["user_name"] . "</td>
                    <td>" . $task["email"] . "</td>
                    <td>" . $task["text"] . "<br>" . $task["edit_by_admin"] . "</td>
                    <td>" . $task["status"] . "</td>
                </tr>";
        }
    ?>
    </tbody>
</table>

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
        Задача успешно создана!
    </div>
<?php } ?>

<form id="add-task-form" action="/main/add_task" method="post">
    <div class="form-row align-items-center">
        <div class="col-auto">
            <label class="sr-only" for="user-name-input">Имя пользователя</label>
            <input type="text" class="form-control mb-2" id="user-name-input" name="user_name" placeholder="Имя пользователя" required>
        </div>
        <div class="col-auto">
            <label class="sr-only" for="email-input">E-Mail</label>
            <input type="email" class="form-control mb-2" id="email-input" name="email" placeholder="E-Mail" required>
        </div>
        <div class="col-md-5">
            <label class="sr-only" for="text-input">Текст задачи</label>
            <input type="text" class="form-control mb-2" id="text-input" name="text" placeholder="Текст задачи" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2">Создать задачу</button>
        </div>
    </div>
</form>