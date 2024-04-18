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
  CookieJs.set(key, theme, { expires: 30 });
  document.body.setAttribute("data-bs-theme", theme);
};

export const toggleThemeMode = () => {
  const theme = getThemeMode();
  changeThemeMode(theme === "light" ? "dark" : "light");
};

export const getXSRFToken = () => {
  return { key: window.__x_csrf_key, value: window.__x_csrf_token };
};

export const extendSettingTime = () => {
  const theme = getThemeMode();
  changeThemeMode(theme);
  const themeKey = "PHPTOGGLESIDEBAR";
  const sidebar = CookieJs.get(themeKey);
  CookieJs.set(themeKey, sidebar, { expires: 30 });
};
