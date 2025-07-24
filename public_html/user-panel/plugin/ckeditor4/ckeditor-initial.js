CKEDITOR.replace("editor1", {
  customConfig: "./config.js",
});
CKEDITOR.replace("editor2", {
  customConfig: "./config.js",
});

CKEDITOR.config.height = 250;
CKEDITOR.config.width = "auto";
CKEDITOR.config.language = "fa";

// CKEDITOR.editorConfig = function (config) {
//     config.language = 'fa';
//     config.uiColor = '#F7B42C';
//     config.toolbarCanCollapse = true;
// };
