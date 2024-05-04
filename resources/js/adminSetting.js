import $ from "jquery";
import { getThemeMode } from "./helpers";
import "./adminLayout";

(async () => {
  $(function () {
    $("#setting-form").find("#theme-mode").val(getThemeMode());
  });
})();
