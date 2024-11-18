<?php
include 'header.php';
$faqModel = new FAQ();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_faqs = $faqModel->getTotalFAQCount();
$items_per_page = 5;
$total_pages = ceil($total_faqs / $items_per_page);
$allFaq = $faqModel->getAllFAQ($page);
?>
<style>
    /* styles.css */

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container1 {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
    }

    .container1 {
        width: 70%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .faq-title {
        text-align: center;
        font-size: 2rem;
        color: #333;
        margin-bottom: 20px;
    }

    .accordion {
        width: 100%;
    }

    .accordion-item {
        margin-bottom: 10px;
    }

    .accordion-button {
        width: 100%;
        padding: 15px;
        background-color: #5bc0de;
        color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        text-align: left;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-button:hover {
        background-color: #4fa3b1;
    }

    .accordion-content {
        padding: 15px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-top: none;
        display: none; /* Initially hidden */
        border-radius: 8px;
    }

    .accordion-content p {
        font-size: 1rem;
        color: #555;
    }

    /* Thêm icon */
    .icon {
        font-size: 1.2rem;
        transition: transform 0.3s ease; /* Thêm hiệu ứng khi xoay icon */
    }

    .accordion-button.active .icon {
        transform: rotate(90deg); /* Xoay icon khi câu trả lời được hiển thị */
    }
</style>
<div class="container1">
        <h2 class="faq-title">Câu Hỏi Thường Gặp (FAQ)</h2>

        <div class="accordion">
            <?php foreach ($allFaq as $key => $value) { ?>
            <div class="accordion-item">
                <button class="accordion-button" onclick="toggleAccordion(this)">
                    <?php  echo $value['question'] ?>
                    <i class="fa fa-chevron-right icon"></i> <!-- Icon here -->
                </button>
                <div class="accordion-content">
                    <p><strong><?php echo $value['answer'] ?></strong></p>
                </div>
            </div>
            <?php } ?>
        </div>
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
</div>

<script>
function toggleAccordion(button) {
    const content = button.nextElementSibling;
    if (content.style.display === "none" || content.style.display === "") {
        content.style.display = "block";
    } else {
        content.style.display = "none";
    }
}
</script>
<?php
include 'footer.php';
?>