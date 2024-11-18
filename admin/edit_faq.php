<?php 
include 'header.php'; 
require_once '../model/faq.php';

$faqModel = new FAQ();
$faq_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$faq = $faqModel->getFAQById($faq_id);
if (!$faq) {
    echo "FAQ không tồn tại.";
    exit;
}
?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <?php include 'sidebar.php' ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Card chỉnh sửa câu hỏi -->
            <div class="card mt-4 shadow-lg" style="border-radius: 10px;">
                <div class="card-header" style="background-color: #5bc0de; color: white; border-radius: 10px 10px 0 0;">
                    <h4 class="mb-0">Chỉnh Sửa Câu Hỏi Thường Gặp</h4>
                </div>
                <div class="card-body" style="background-color: #f8f9fa;">
                    <form action="../controller/updateFAQController.php" method="POST">
                        <input type="hidden" name="faq_id" value="<?= $faq['id'] ?>">
                        
                        <div class="form-group">
                            <label for="question" class="font-weight-bold" style="color: #333;">Câu hỏi</label>
                            <input type="text" class="form-control" id="question" name="question" value="<?= htmlspecialchars($faq['question']) ?>" placeholder="Nhập câu hỏi" required>
                        </div>

                        <div class="form-group">
                            <label for="answer" class="font-weight-bold" style="color: #333;">Trả lời</label>
                            <textarea class="form-control" id="answer" name="answer" rows="4" placeholder="Nhập câu trả lời" required><?= htmlspecialchars($faq['answer']) ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-success mt-3" style="border-radius: 5px;">Cập Nhật FAQ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- plugins:js --> 
<?php include 'footer.php'; ?>
