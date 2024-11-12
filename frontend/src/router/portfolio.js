import { createRouter, createWebHistory } from "vue-router";
const Portfolio = () => import("@/views/Portfolio.vue");
const ResetPassword = () => import("@/views/auth/ResetPassword.vue");

const portfolio = [
  {
    path: "/",
    name: "Portfolio",
    component: Portfolio,
  },
  {
    path: "/reset-password",
    name: "ResetPassword",
    component: ResetPassword,
    props: (route) => ({ token: route.query.token, email: route.query.email }), // Truyền token và email qua props
  },
];

export default portfolio;
