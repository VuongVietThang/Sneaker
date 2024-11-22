<script src="../js/vendor.bundle.base.js"></script>
<!-- inject:js -->
<script src="../js/sidebar-menu.js"></script>
<!-- Thêm Chart.js -->
<script src="../js/Chart.min.js"></script>

<script>
    const stats = {
        months: <?php echo json_encode($months); ?>,
        sales: <?php echo json_encode($salesData); ?>,
        users: <?php echo json_encode($userData); ?>,
        products: <?php echo json_encode($productData); ?>,
        orders: <?php echo json_encode($orderData); ?>
    };
</script>


</body>

</html>