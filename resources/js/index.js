import $ from "jquery";
import { extendSettingTime } from "./helpers";
import "bootstrap";
import "../scss/index.scss";

(async () => {
  $(function () {
    extendSettingTime();
  });
})();
