import $ from "jquery";
import { changeThemeMode, getThemeMode } from "./helpers";

$(function () {
  $("#setting-form").find("#theme-mode").val(getThemeMode());
  $("#setting-form").on("submit", function (event) {
    const theme = $(this).find("#theme-mode").val();
    changeThemeMode(theme);
  });
});
