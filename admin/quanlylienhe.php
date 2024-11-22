<?php 
include 'header.php'; 
$contactModel = new Contact();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_faqs = $contactModel->getTotalContactCount();
$items_per_page = 5;

// Tính số trang tổng cộng
$total_pages = ceil($total_faqs / $items_per_page);
$allContact = $contactModel->getAllContact($page, $items_per_page);
?>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <?php include 'sidebar.php' ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <h2 class="mb-4 text-center" style="color: #007bff;">Danh sách các liên hệ</h2>

            <!-- Table -->
            <div class="card shadow-sm border-light">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Danh Sách liên hệ</h4>
                </div>
                <div class="card-body bg-light">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allContact as $contact): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($contact['id']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['message']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['created_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <nav aria-label="Page navigation example" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?= max(1, $page - 1) ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>

                    <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- plugins:js --> 
<?php include 'footer.php'; ?> 
