// Cấu hình chung cho các biểu đồ
const options = {
  responsive: true,
  plugins: {
    // tooltip: { callbacks: { label: (ctx) => `${ctx.raw}` } },
  },
  animation: {
    duration: 2000, // Thời gian hiệu ứng animation (1 giây)
    easing: "easeInOutCubic", // Hiệu ứng easing mượt mà
  },
};

// Biểu đồ Doanh Thu (6 tháng)
const salesCtx = document.getElementById("salesChart").getContext("2d"); // Lấy ngữ cảnh 2D
new Chart(salesCtx, {
  type: "line",
  data: {
    labels: stats.months, // Tháng
    datasets: [
      {
        label: "Revenue",
        backgroundColor: "rgba(255, 255, 255, 0.1)",
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: 1,
        data: stats.sales, // Doanh thu
        // fill: false,
        tension: 0.4,
        // pointRadius: 0, // Tắt dấu chấm trên đường
        // pointHoverRadius: 0
      },
    ],
  },
  options
});

//

// Biểu đồ Người Dùng (6 tháng)
const userCtx = document.getElementById("userChart").getContext("2d"); // Lấy ngữ cảnh 2D
new Chart(userCtx, {
  type: "bar",
  data: {
    labels: stats.months, // Tháng
    datasets: [
      {
        label: "New Users",
        backgroundColor: "rgba(54, 162, 235, 0.2)",
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: 1,
        data: stats.users, // Số người dùng mới
      },
    ],
  },
  options
});

// Biểu đồ Sản Phẩm (6 tháng)
const productsCtx = document.getElementById("productsChart").getContext("2d"); // Lấy ngữ cảnh 2D
new Chart(productsCtx, {
  type: "line",
  data: {
    labels: stats.months, // Tháng
    datasets: [
      {
        label: "Products Sold",
        backgroundColor: "rgba(255, 255, 255, 0.1)",
        borderColor: "rgba(255,99,132,1)",
        borderWidth: 1,
        data: stats.products, // Số sản phẩm đã bán
        // fill: false,
        tension: 0.4,
        // pointRadius: 0, // Tắt dấu chấm trên đường
        // pointHoverRadius: 0
      },
    ],
  },
  options
});

// Biểu đồ Đơn Hàng (6 tháng)
const ordersCtx = document.getElementById("ordersChart").getContext("2d"); // Lấy ngữ cảnh 2D
new Chart(ordersCtx, {
  type: "bar",
  data: {
    labels: stats.months, // Tháng
    datasets: [
      {
        label: "Orders",
        backgroundColor: "rgba(255, 99, 132, 0.2)",
        borderColor: "rgba(255,99,132,1)",
        borderWidth: 1,
        data: stats.orders, // Số đơn hàng
      },
    ],
  },
  options
});
