import CookieJs from "js-cookie";

export const trans = (key, replace = {}) => {
  let translation = window.__lang_data[key] || "";
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

export const changeThemeMode = (theme) => {
  const key = "PHPTHEME";
  CookieJs.set(key, theme);
  document.body.setAttribute("data-bs-theme", theme);
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

export const getXSRFToken = () => {
  return { key: window.__x_csrf_key, value: window.__x_csrf_token };
};
