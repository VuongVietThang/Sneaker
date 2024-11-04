
  // Biểu đồ Doanh Thu
  const revenueCtx = document.getElementById('revenueChart').getContext('2d');
  const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
      labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
      datasets: [{
        label: 'Doanh thu',
        data: [1200, 1900, 3000, 5000, 2300, 3200], // Dữ liệu doanh thu mẫu
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Biểu đồ Người Dùng Mới
  const usersCtx = document.getElementById('newUsersChart').getContext('2d');
  const newUsersChart = new Chart(usersCtx, {
    type: 'bar',
    data: {
      labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
      datasets: [{
        label: 'Người dùng mới',
        data: [50, 80, 45, 90, 120, 75], // Dữ liệu người dùng mới mẫu
        backgroundColor: 'rgba(153, 102, 255, 0.2)',
        borderColor: 'rgba(153, 102, 255, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

