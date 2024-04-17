<!DOCTYPE html>
<html lang="vi">

<head>
    <?php partial("generic-head.php", compact("seo")) ?>
</head>

<body>
    <div id="admin-layout">
        <?php partial("admin-sidebar.php", compact("features")) ?>
        <div class="admin-wrapper">
            <h1 class="cms-title"><?php echo $seo->title ?></h1>
            <section class="cms-section">
                <div class="d-flex align-items-center justify-content-between gap-2 mb-4">
                    <form class="input-group" style="max-width: 500px" title="<?php echo trans("search_user_placeholder") ?>">
                        <input type="text" class="form-control" id="search-input" placeholder="<?php echo trans("search_user_placeholder") ?>">
                        <button class="input-group-text btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <button class="btn btn-primary flex-shrink-0" title="<?php echo trans("add_new_user") ?>">
                        <i class="bi bi-plus-lg"></i>
                        <?php echo trans("add_new_user") ?>
                    </button>
                </div>
                <div class="table-sticky-container" style="height: 600px">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%">#</th>
                                <th scope="col" style="width: 15%">
                                    <?php echo trans("email_address") ?>
                                </th>
                                <th scope="col" style="width: 15%">
                                    <?php echo trans("name") ?>
                                </th>
                                <th scope="col" style="width: 15%">
                                    <?php echo trans("dob") ?>
                                </th>
                                <th scope="col" style="width: 15%">
                                    <?php echo trans("gender") ?>
                                </th>
                                <th scope="col" style="width: 15%">
                                    <?php echo trans("role") ?>
                                </th>
                                <th scope="col" style="width: 10%">
                                    <?php echo trans("status") ?>
                                </th>
                                <th scope="col" style="width: 10%">
                                    <?php echo trans("action") ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php if (isset($users) && count($users) > 0) : ?>
                                <?php foreach ($users as $index => $user) : ?>
                                    <tr>
                                        <th style="vertical-align: middle" scope="row">
                                            <?php echo $index + 1 ?>
                                        </th>
                                        <td style="vertical-align: middle">
                                            <?php echo $user->email ?>
                                        </td>
                                        <td style="vertical-align: middle">
                                            <?php echo $user->name ?>
                                        </td>
                                        <td style="vertical-align: middle">
                                            <?php echo $user->dob ?>
                                        </td>
                                        <td style="vertical-align: middle">
                                            <?php echo $user->getGender() ?>
                                        </td>
                                        <td style="vertical-align: middle">
                                            <?php echo $user->getRole() ?>
                                        </td>
                                        <td style="vertical-align: middle">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" checked="checked" data-action="<?php echo route("/admin/mng/users/edit.json") ?>" data-id="<?php echo $user->id ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <a class=" btn btn-sm btn-outline-primary" href="<?php echo route("/admin/mng/users/show.html", ["id" => $user->id]) ?>">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a class="btn btn-sm btn-outline-warning" href="<?php echo route("/admin/mng/users/edit.html", ["id" => $user->id]) ?>">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="text-center p-3">
                                        <?php echo trans("no_data") ?>
                                    </td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <?php if (isset($users) && count($users) > 0) : ?>
                    <div class="d-flex align-items-center justify-content-between gap-2  mt-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link disabled" href="#" aria-label="Previous">
                                        <i class="bi bi-chevron-bar-left"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link disabled" href="#" aria-label="Previous">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link active" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <i class="bi bi-chevron-bar-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <div>
                            <small>
                                <?php echo trans("pagination_desc", [
                                    "from" => 1,
                                    "to" => 10,
                                    "total" => 100
                                ]) ?>
                            </small>
                        </div>
                    </div>
                <?php endif ?>
            </section>
        </div>
    </div>

    <?php partial("generic-scripts.php") ?>
    <script src="<?php echo assets("/vendor/adminUserManagement.bundle.js") ?>"></script>
</body>

</html>