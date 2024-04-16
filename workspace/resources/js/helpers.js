import CookieJs from "js-cookie";

export const trans = (key, replace = {}) => {
  let translation = window.__langData[key] || "";
  for (let placeholder in replace) {
    translation = translation.replace(`:${placeholder}`, replace[placeholder]);
  }
  return translation;
};

export const getThemeMode = () => {
  const key = "PHPTHEME";
  const theme = CookieJs.get(key) || "light";
  return theme;
};

export const toggleThemeMode = () => {
  const key = "PHPTHEME";
  const theme = getThemeMode();
  CookieJs.set(key, theme === "light" ? "dark" : "light");
  document.body.setAttribute(
    "data-bs-theme",
    theme === "light" ? "dark" : "light"
  );
};
