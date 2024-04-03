import $ from "jquery";
import "../scss/adminLogin.scss";

$(function () {
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
