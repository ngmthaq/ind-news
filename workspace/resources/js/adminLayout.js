import $ from "jquery";
import CookieJs from "js-cookie";
import {
  getThemeMode,
  toggleThemeMode as toggleThemeModeHelper,
} from "./helpers";
import "../scss/adminLayout.scss";

(async () => {
  $(function () {
    function toggleSidebar() {
      const key = "PHPTOGGLESIDEBAR";
      const hideIcon = $("#sidebar-toggle-width-button").data("hide-icon");
      const showIcon = $("#sidebar-toggle-width-button").data("show-icon");
      let isOpenSidebar = Boolean(CookieJs.get(key));
      isOpenSidebar
        ? CookieJs.set(key, "", { expires: 30 })
        : CookieJs.set(key, "1", { expires: 30 });
      isOpenSidebar = Boolean(CookieJs.get(key));

      $("#sidebar-toggle-width-button").html(
        isOpenSidebar
          ? `<i class="${showIcon}"></i>`
          : `<i class="${hideIcon}"></i>`
      );

      isOpenSidebar
        ? $(".admin-sidebar").addClass("minimize")
        : $(".admin-sidebar").removeClass("minimize");
    }

    function toggleThemeMode() {
      toggleThemeModeHelper();
      const theme = getThemeMode();
      const lightModeIcon = $("#toggle-theme-cms-button").data("light-icon");
      const darkModeIcon = $("#toggle-theme-cms-button").data("dark-icon");

      $("#toggle-theme-cms-button").html(
        theme === "light"
          ? `<i class="${darkModeIcon}"></i>`
          : `<i class="${lightModeIcon}"></i>`
      );

      $("#toggle-theme-cms-button").removeClass("btn-light");
      $("#toggle-theme-cms-button").removeClass("btn-dark");

      $("#toggle-theme-cms-button").addClass(
        theme === "light" ? "btn-dark" : "btn-light"
      );
    }

    $("#sidebar-toggle-width-button").on("click", function () {
      toggleSidebar();
    });

    $("#toggle-theme-cms-button").on("click", function () {
      toggleThemeMode();
    });

    $(document).on("keyup", function (event) {
      // Ctrl+B to toggle sidebar
      if (event.which === 66 && event.ctrlKey === true) {
        toggleSidebar();
      }

      // Ctrl+M to toggle theme mode
      if (event.which === 77 && event.ctrlKey === true) {
        toggleThemeMode();
      }
    });
  });
})();
