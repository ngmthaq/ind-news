import { getThemeMode } from "./helpers";
import "../scss/index.scss";

(() => {
  const theme = getThemeMode();
  document.body.setAttribute("data-bs-theme", theme);
})();
