import $ from "jquery";
import CookieJs from "js-cookie";
import "../scss/adminLayout.scss";

(async () => {
  $(function () {
    const key = "PHPTOGGLESIDEBAR";
    const hideIcon = $("#sidebar-toggle-width-button").data("hide-icon");
    const showIcon = $("#sidebar-toggle-width-button").data("show-icon");

    function toggleSidebar() {
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

    $("#sidebar-toggle-width-button").on("click", function () {
      toggleSidebar();
    });

    $(document).on("keyup", function (event) {
      // Ctrl+B to toggle sidebar
      if (event.which === 66 && event.ctrlKey === true) {
        toggleSidebar();
      }
    });
  });
})();
