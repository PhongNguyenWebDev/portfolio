import store from "@/store/modules/auth.js";
import Cookies from "js-cookie";

// Layouts
const Dashboard = () => import("@/components/admin/DashboardLayout.vue");
const NotFound = () => import("@/views/errors/Error401.vue");

// About Management
const AboutMe = () => import("@/views/ManagementAboutMe/AboutMeLayout.vue");
const CreateAboutMe = () =>
  import("@/views/ManagementAboutMe/CreateAboutMe.vue");
const EditAboutMe = () => import("@/views/ManagementAboutMe/EditAboutMe.vue");

// Work Experience Management
const CreateWorkEx = () => import("@/views/ManagementAboutMe/CreateWorkEx.vue");
const EditWorkEx = () => import("@/views/ManagementAboutMe/EditWorkEx.vue");

// Icon Management
const Icon = () => import("@/views/ManagementIcon/IconLayout.vue");
const CreateIcon = () => import("@/views/ManagementIcon/CreateIcon.vue");
const EditIcon = () => import("@/views/ManagementIcon/EditIcon.vue");

// Project Management
const Project = () => import("@/views/ManagementProject/ProjectLayout.vue");
const CreateProject = () =>
  import("@/views/ManagementProject/CreateProject.vue");
const EditProject = () => import("@/views/ManagementProject/EditProject.vue");

// Skills Management
const Skill = () => import("@/views/ManagementSkill/SkillLayout.vue");
const CreateSkill = () => import("@/views/ManagementSkill/CreateSkill.vue");
const EditSkill = () => import("@/views/ManagementSkill/EditSkill.vue");

// Slider Management
const Slider = () => import("@/views/ManagementSlider/SliderLayout.vue");

// General Management
const General = () => import("@/views/ManagementGeneral/GeneralLayout.vue");

// Profile Management
const Profile = () => import("@/views/ManagementProfile/ProfileLayout.vue");

// Auth Guard
const requireAuth = (to, from, next) => {
  const isAuthenticated = Cookies.get("token");
  if (isAuthenticated) {
    next();
  } else {
    next({ path: "/NotFound" });
  }
};

const routes = [
  {
    path: "/NotFound",
    name: "NotFound",
    component: NotFound,
  },
  {
    path: "/admin",
    component: Dashboard,
    beforeEnter: requireAuth,
    children: [
      // Dashboard Home
      { path: "profile", name: "Profile", component: Profile },

      // About Me Management
      {
        path: "about-me",
        component: AboutMe,
        children: [{ path: "", name: "AboutMe", component: AboutMe }],
      },

      {
        path: "about-me/create",
        name: "CreateAboutMe",
        component: CreateAboutMe,
      },
      {
        path: "about-me/edit/:id",
        name: "EditAboutMe",
        component: EditAboutMe,
        props: true,
      },

      // Work Experience Management
      {
        path: "work-experience",
        children: [
          { path: "create", name: "CreateWorkEx", component: CreateWorkEx },
          {
            path: "edit/:id",
            name: "EditWorkEx",
            component: EditWorkEx,
            props: true,
          },
        ],
      },
      // Icon Management
      {
        path: "icon",
        children: [
          { path: "", name: "Icon", component: Icon },
          { path: "create", name: "CreateIcon", component: CreateIcon },
          {
            path: "edit/:id",
            name: "EditIcon",
            component: EditIcon,
            props: true,
          },
        ],
      },

      // Project Management
      {
        path: "project",
        children: [
          { path: "", name: "Project", component: Project },
          { path: "create", name: "CreateProject", component: CreateProject },
          {
            path: "edit/:id",
            name: "EditProject",
            component: EditProject,
            props: true,
          },
        ],
      },

      // Skill Management
      {
        path: "skill",
        children: [
          { path: "", name: "Skill", component: Skill },
          { path: "create", name: "CreateSkill", component: CreateSkill },
          {
            path: "edit/:id",
            name: "EditSkill",
            component: EditSkill,
            props: true,
          },
        ],
      },

      // Slider Management
      { path: "slider", name: "Slider", component: Slider },

      // General Management
      { path: "general", name: "General", component: General },

      // Profile Management
      { path: "profile", name: "Profile", component: Profile },
    ],
  },
];

export default routes;
