import $ from "jquery";
import "./adminLayout";
import "../scss/adminUserUpdate.scss";

(async () => {
  $("#avatar").on("change", function (event) {
    const target = event.target;
    const files = target.files;
    if (files.length === 0) {
      $("#avatar-preview").attr("src", $("#avatar").data("default-avatar"));
    } else {
      const file = files[0];
      const url = URL.createObjectURL(file);
      $("#avatar-preview").attr("src", url);
    }
  });

  $("form#user-info-form button[type='reset'").on("click", function () {
    $("#avatar").val("");
    $("#avatar-preview").attr("src", $("#avatar").data("default-avatar"));
  });
})();
