import $ from "jquery";
import { trans } from "./helpers";
import "../scss/adminLogin.scss";

$(function () {
  console.log(trans("cms_title"));

  $("#toggle-show-password").on("click", function () {
    const isShowPassword = $(this).data("show");
    const showIcon = $(this).data("show-icon");
    const hideIcon = $(this).data("hide-icon");
    if (isShowPassword === true) {
      $("#password").attr("type", "password");
      $(this).html(`<i class="${showIcon}"></i>`);
    } else {
      $("#password").attr("type", "text");
      $(this).html(`<i class="${hideIcon}"></i>`);
    }
    $(this).data("show", !isShowPassword);
  });
});
