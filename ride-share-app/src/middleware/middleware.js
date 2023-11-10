// middleware.js

export function isAuthenticated(to, from, next) {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    const isAuthenticated = localStorage.getItem('token');
  
    if (isAuthenticated) {
      // Nếu đã đăng nhập, cho phép truy cập
      next();
    } else {
      // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
      next({
        name: 'login', // Thay thế 'login' bằng tên route của trang đăng nhập
        query: { auth: to.fullPath }, // Truyền đường dẫn đến trang đến khi chuyển hướng
      });
    }
  }
  