<?php include_once './../../services/controller/CheckLoginController.php'; ?>
<?php
include_once '../../services/api/repository/PaymentRepository.php';

$paymentRepository = new PaymentRepository();
$paymentList = $paymentRepository->getAll();
$nameValue = isset($_GET['name']) ? $_GET['name'] : '';
$idValue = isset($_GET['id']) ? $_GET['id'] : '';
if ($nameValue) {
    foreach ($paymentList as $key => $payment) {
        if (strpos($payment['name'], $nameValue) === false) {
            unset($paymentList[$key]);
        }
    }
}
if ($idValue) {
    foreach ($paymentList as $key => $payment) {
        if ($payment['id'] != $idValue) {
            unset($paymentList[$key]);
        }
    }
}
$paymentCount = count($paymentList);
$itemPerPage = isset($_GET['item']) ? (int)$_GET['item'] : 5;
$page = ceil($paymentCount / $itemPerPage);
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = $currentPage > $page ? 1 : $currentPage;
$offSet = $itemPerPage * ($currentPage - 1);

if ($paymentCount > $itemPerPage) {
    $paymentList = array_slice($paymentList, $offSet, $itemPerPage, true);
}
$prePage = $currentPage > 1 ? $currentPage - 1 : false;
$nextPage = $itemPerPage < $paymentCount && $currentPage < $page ? $currentPage + 1 : false;
?>
<?php include_once './../common/header.php' ?>

<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include_once './../common/side-bar.php'; ?>
        <div class="layout-page">
            <?php include_once './../common/nav-bar.php'; ?>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Payment Methods</h4>
                    <a href="create-payment.php" class="mb-3 btn btn-primary">Create Payment Method</a>
                    <div class="card">
                        <h5 class="card-header"><?= $paymentCount . ' records found' ?></h5>
                        <div class="container">
                            <form id="search" method="POST">
                                <div class="mb-3">
                                    <label for="id" class="form-label">Id</label>
                                    <input type="text" class="form-control" name="id" value="<?= $idValue ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="<?= $nameValue ?>">
                                </div>
                                <a id="reset" class="btn btn-gray">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply</button>
                            </form>
                        </div>
                        <div class="container paging-group">
                            <div class="input-group my-data--in-page" style="width: 100px">
                                <input type="text" class="form-control" value="<?= $itemPerPage ?>" id="item-per-page">
                                <div class="dropdown">
                                    <button class="my-btn__dropdown--group btn btn-secondary dropdown-toggle"
                                            type="button" id="dropdownItemPerPage" data-bs-toggle="dropdown"></button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownItemPerPage">
                                        <li><a class="dropdown-item item-per-page" data-value="5">5</a></li>
                                        <li><a class="dropdown-item item-per-page" data-value="10">10</a></li>
                                        <li><a class="dropdown-item item-per-page" data-value="20">20</a></li>
                                        <li><a class="dropdown-item item-per-page" data-value="50">50</a></li>
                                        <li><a class="dropdown-item item-per-page" data-value="100">100</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="my-input-group">
                                <?php if ($prePage) { ?>
                                    <button id="pre-page" data-value="<?= $prePage ?>" class="btn btn-danger">
                                        <
                                    </button>
                                <?php } ?>
                                <input type="text" class="form-control" value="<?= $currentPage ?>" id="page">
                                <span><?= 'of ' . $page ?></span>
                                <?php if ($nextPage) { ?>
                                    <button id="next-page" data-value="<?= $nextPage ?>" class="btn btn-danger">>
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>payment Code</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                <?php foreach ($paymentList as $payment) { ?>
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong><?= $payment['id'] ?></strong>
                                        </td>
                                        <td><?= $payment['name'] ?></td>
                                        <td><?= $payment['code'] ?></td>
                                        <td>
                                            <?php if ($payment['status'] == 1) : ?>
                                                <span class="badge bg-label-primary me-1">Active</span>
                                            <?php else : ?>
                                                <span class="badge bg-label-success me-1">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $payment['price'] ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                       href="../../services/controller/PaymentController.php?action=getById&id=<?= $payment['id'] ?>">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item"
                                                       href="../../services/controller/PaymentController.php?action=delete&id=<?= $payment['id'] ?>">
                                                        <i class="bx bx-trash me-1"></i>Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<script src="./../assets/vendor/libs/jquery/jquery.js"></script>
<script src="./../assets/vendor/libs/popper/popper.js"></script>
<script src="./../assets/vendor/js/bootstrap.js"></script>
<script src="./../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="./../assets/vendor/js/menu.js"></script>
<script src="./../assets/js/main.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script>
    $(document).ready(function () {
        var queryParams = new URLSearchParams(window.location.search);
        queryParams.set("page", $('#page').val());
        history.replaceState(null, null, "?" + queryParams.toString());
        $('#search').on('submit', function (e) {
            e.preventDefault();
            var data = $(this).serializeArray();
            $.each(data, function (key, val) {
                queryParams.set(val.name, val.value);
            });
            history.replaceState(null, null, "?" + queryParams.toString());
            window.location.href = window.location.href;
        });
        $('#reset').on('click', function (e) {
            e.preventDefault();
            queryParams.set('id', '');
            queryParams.set('name', '');
            history.replaceState(null, null, "?" + queryParams.toString());
            window.location.href = window.location.href;
        });
        $('#page').on('change', function () {
            var page = this.value;
            if (!page || Math.floor(page) != page || !$.isNumeric(page)) {
                page = 1;
            }
            queryParams.set("page", page);
            history.replaceState(null, null, "?" + queryParams.toString());
            window.location.href = window.location.href;
        });
        $('#pre-page').on('click', function (e) {
            e.preventDefault();
            var page = $(this).data('value');
            if (!page || Math.floor(page) != page || !$.isNumeric(page)) {
                page = 1;
            }
            queryParams.set("page", page);
            history.replaceState(null, null, "?" + queryParams.toString());
            window.location.href = window.location.href;
        });
        $('#next-page').on('click', function (e) {
            e.preventDefault();
            var page = $(this).data('value');
            if (!page || Math.floor(page) != page || !$.isNumeric(page)) {
                page = 1;
            }
            queryParams.set("page", page);
            history.replaceState(null, null, "?" + queryParams.toString());
            window.location.href = window.location.href;
        });
        $('#item-per-page').on('change', function () {
            var item = this.value;
            if (!item || Math.floor(item) != item || !$.isNumeric(item)) {
                item = 10;
            }
            queryParams.set("item", item);
            history.replaceState(null, null, "?" + queryParams.toString());
            window.location.href = window.location.href;
        });
        $('.item-per-page').on('click', function () {
            var item = $(this).data('value');
            if (!item || Math.floor(item) != item || !$.isNumeric(item)) {
                item = 10;
            }
            queryParams.set("item", item);
            history.replaceState(null, null, "?" + queryParams.toString());
            window.location.href = window.location.href;
        });
    })
</script>
</body>
</html>