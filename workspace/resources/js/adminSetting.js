import $ from "jquery";
import { changeThemeMode, getThemeMode } from "./helpers";
import "./adminLayout";

$(function () {
  $("#setting-form").find("#theme-mode").val(getThemeMode());
  $("#setting-form").on("submit", function () {
    const theme = $(this).find("#theme-mode").val();
    changeThemeMode(theme);
  });
});
