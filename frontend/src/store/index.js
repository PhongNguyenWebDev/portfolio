import { createStore } from "vuex";

const moduleNames = [
  "auth",
  "about-me",
  "work-ex",
  "skill",
  "profile",
  "icon",
  "project",
  "slider",
  "general",
];
const modules = {};

await Promise.all(
  moduleNames.map(async (name) => {
    modules[name] = (await import(`./modules/${name}.js`)).default;
  })
);

const store = createStore({
  modules,
});

if (
  store._modules.root._children.auth &&
  typeof store.dispatch === "function"
) {
  store.dispatch("auth/initializeStore");
}

export default store;
