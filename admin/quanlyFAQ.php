<?php 
include 'header.php'; 
$faqModel = new FAQ();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_faqs = $faqModel->getTotalFAQCount();
$items_per_page = 5;

// Tính số trang tổng cộng
$total_pages = ceil($total_faqs / $items_per_page);
$allFaq = $faqModel->getAllFAQ($page);
?>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <?php include 'sidebar.php' ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <h2 class="mb-4 text-center" style="color: #007bff;">Danh sách Câu Hỏi Thường Gặp (FAQ)</h2>

            <!-- Table -->
            <div class="card shadow-sm border-light">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Danh Sách FAQ</h4>
                </div>
                <div class="card-body bg-light">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Câu hỏi</th>
                                <th>Trả lời</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($allFaq as $key => $value) { ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo htmlspecialchars($value['question']) ?></td>
                                <td><?php echo htmlspecialchars($value['answer']) ?></td>
                                <td>
                                    <a href="edit_faq.php?id=<?php echo $value['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="../controller/delete_faq.php?id=<?= $value['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')">Xóa</a>
                                </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Phân trang -->
            <nav aria-label="Page navigation example" class="mt-4">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= max(1, $page - 1) ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <!-- Page Number Links -->
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>

                    <!-- Next Button -->
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Form thêm câu hỏi mới -->
            <div class="card mt-4 shadow-sm border-secondary">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Thêm Câu Hỏi Mới</h4>
                </div>
                <div class="card-body bg-light">
                    <form action="../controller/addFAQController.php" method="POST">
                        <div class="form-group">
                            <label for="question" class="font-weight-bold text-dark">Câu hỏi</label>
                            <input type="text" class="form-control border-secondary" id="question" name="question" placeholder="Nhập câu hỏi" required>
                        </div>
                        <div class="form-group">
                            <label for="answer" class="font-weight-bold text-dark">Trả lời</label>
                            <textarea class="form-control border-secondary" id="answer" name="answer" rows="4" placeholder="Nhập câu trả lời" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block">Thêm FAQ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- plugins:js --> 
<?php include 'footer.php'; ?> 
