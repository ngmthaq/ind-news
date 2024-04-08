import $ from "jquery";
import CookieJs from "js-cookie";
import "../scss/index.scss";

(async () => {
  const key = "PHPADMSIDEBARCLOSE";
  const isOpenSidebar = Boolean(CookieJs.get(key));
  const hideIcon = $("#sidebar-toggle-width-button").data("hide-icon");
  const showIcon = $("#sidebar-toggle-width-button").data("show-icon");

  $("#sidebar-toggle-width-button").html(
    isOpenSidebar
      ? `<i class="${showIcon}"></i>`
      : `<i class="${hideIcon}"></i>`
  );

  isOpenSidebar
    ? $(".admin-sidebar").addClass("minimize")
    : $(".admin-sidebar").removeClass("minimize");

  $("#sidebar-toggle-width-button").on("click", function () {
    let isOpenSidebar = Boolean(CookieJs.get(key));
    isOpenSidebar ? CookieJs.remove(key) : CookieJs.set(key, 1);
    isOpenSidebar = Boolean(CookieJs.get(key));

    $("#sidebar-toggle-width-button").html(
      isOpenSidebar
        ? `<i class="${showIcon}"></i>`
        : `<i class="${hideIcon}"></i>`
    );

    isOpenSidebar
      ? $(".admin-sidebar").addClass("minimize")
      : $(".admin-sidebar").removeClass("minimize");
  });
})();
