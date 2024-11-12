import ScrollReveal from "scrollreveal";

// Khởi tạo ScrollReveal với cấu hình mặc định
const sr = ScrollReveal({
  origin: "bottom",
  distance: "100px",
  duration: 1000,
  easing: "ease-in-out",
  delay: 300,
  reset: false, // Không lặp lại animation khi cuộn lên
});

// Hàm tiện ích để tiết kiệm mã lặp lại
const revealWithOptions = (selector, options = {}) => {
  sr.reveal(selector, {
    ...options,
  });
};

// Định nghĩa các animation cho từng phần tử
const revealElements = () => {
  // Sử dụng các cấu hình khác nhau cho từng nhóm phần tử
  revealWithOptions(".slider");

  revealWithOptions(".fade-in", {
    duration: 2000,
    delay: 700,
  });

  revealWithOptions(".about", {
    interval: 200,
  });

  revealWithOptions(".about_item", {
    duration: 1000,
    delay: 700,
  });
  revealWithOptions(".about_ex", {
    duration: 2000,
    delay: 700,
  });

  revealWithOptions(".skills", {
    interval: 200,
  });

  revealWithOptions(".skills_item", {
    interval: 300,
    duration: 1000,
    delay: 400,
  });

  revealWithOptions(".projects", {
    interval: 200,
  });

  revealWithOptions(".project_item", {
    interval: 300,
    duration: 1000,
    delay: 400,
  });

  revealWithOptions(".contact", {
    interval: 200,
  });

  revealWithOptions(".contact_left", {
    interval: 300,
    duration: 1000,
    delay: 400,
  });

  revealWithOptions(".contact_right", {
    delay: 400,
    duration: 2000,
  });
};

export { revealElements };
