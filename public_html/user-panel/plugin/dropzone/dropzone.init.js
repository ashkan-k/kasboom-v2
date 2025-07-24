Dropzone.options.fileImagesUploadCover = {
  paramName: "file",
  maxFilesize: 0.5,
  url: "/your-upload-url",
  parallelUploads: 1,
  uploadMultiple: false,
  acceptedFiles: "image/*",
    autoProcessQueue: false,
    previewsContainer: null,
    addRemoveLinks: true, // این فعال‌سازی دکمه حذف رو انجام می‌ده
    dictRemoveFile: "حذف تصویر", // متن دکمه حذف به فارسی
  // accept: function (file, done) {
  //     if (file.name == "justinbieber.jpg") {
  //         done("Naha, you don't.");
  //     }
  //     else { done(); }
  // }
};
Dropzone.options.fileImagesLogo = {
  paramName: "file",
  maxFilesize: 0.5,
  url: "/your-upload-url",
  parallelUploads: 1,
  uploadMultiple: false,
  acceptedFiles: "image/*",
    autoProcessQueue: false,
    previewsContainer: null,
    addRemoveLinks: true, // این فعال‌سازی دکمه حذف رو انجام می‌ده
    dictRemoveFile: "حذف تصویر", // متن دکمه حذف به فارسی
};
