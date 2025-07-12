var body = document.querySelector("body");

if (document.querySelector(".mynavbar") !== null) {
  var myNavbar = document.querySelector(".mynavbar");
  var btnServicesMenu = myNavbar.querySelector(".btn-services-menu");
  var overlaySidebar = myNavbar.querySelector(".overlay-sidebar");
  var btnSideBarClose = myNavbar.querySelector(".sidebar-close");
  var sidebarMenu = document.getElementById("sidebar-menu");

  btnServicesMenu.onclick = () => {
    overlaySidebar.classList.add("active");
    sidebarMenu.classList.add("active");
  };
  overlaySidebar.onclick = () => {
    overlaySidebar.classList.remove("active");
    sidebarMenu.classList.remove("active");
  };
  btnSideBarClose.onclick = () => {
    overlaySidebar.classList.remove("active");
    sidebarMenu.classList.remove("active");
  };
}

// Desktop Search Content
if (document.getElementById("btn-desktop-search") !== null) {
  var btnDesktopSearch = document.getElementById("btn-desktop-search");
  var desktopSearchContent = document.getElementById("desktop-search-content");

  var arrowBack = desktopSearchContent.querySelector(".btn-arrow-back");
  var btnclear = desktopSearchContent.querySelector(".btn-clear");
  var mobileSearchInput = document.querySelector(".desktop-search-input");

  btnDesktopSearch.onclick = () => {
    desktopSearchContent.classList.add("active");
    body.classList.add("fixedposition");
  };

  arrowBack.addEventListener("click", function () {
    desktopSearchContent.classList.remove("active");
    body.classList.remove("fixedposition");
  });

  mobileSearchInput.addEventListener("input", (input) => {
    if (input.target.value.length > 0) {
      btnclear.classList.add("active");
    } else {
      btnclear.classList.remove("active");
    }
  });

  btnclear.addEventListener("click", function () {
    mobileSearchInput.value = "";
    this.classList.remove("active");
    mobileSearchInput.focus();
  });
}

// Sign Modal
if (document.getElementById("modal-sign") !== null) {
  var myModal = new bootstrap.Modal(document.getElementById("modal-sign"), {
    keyboard: false,
  });
}

if (document.getElementById("modal-sign") !== null) {
  var modalSignin = document.querySelector(".modal-signin");
  var modalCode = document.querySelector(".modal-code");
  var modalPassword = document.querySelector(".modal-password");
  var btnSign = document.querySelector(".btn-sign");
  var btnLogin = document.querySelector(".btn-login");
  var btnSendCode = document.querySelector(".btn-send-code");
  var btnChangeNumber = document.querySelector(".btn-change-number");
  btnSign.onclick = () => {
    modalSignin.classList.remove("active");
    modalCode.classList.add("active");
    modalPassword.classList.remove("active");
  };
  btnLogin.onclick = () => {
    modalSignin.classList.add("active");
    modalCode.classList.remove("active");
    modalPassword.classList.remove("active");
    myModal.hide();
  };
  btnSendCode.onclick = () => {
    modalSignin.classList.remove("active");
    modalCode.classList.remove("active");
    modalPassword.classList.add("active");
  };
  btnChangeNumber.onclick = () => {
    modalSignin.classList.add("active");
    modalCode.classList.remove("active");
    modalPassword.classList.remove("active");
  };
}

// Login/Sign
if (document.querySelector(".wrapper-login") !== null) {
  var wrapperLogin = document.querySelector(".wrapper-login");
  var selectSignGroup = wrapperLogin.querySelector(".cards-sign-group");
  var formsGroup = wrapperLogin.querySelector(".forms-group");
  var cardsSignChoose = wrapperLogin.querySelectorAll(".card-sign-choose");
  var formSign = wrapperLogin.querySelectorAll(".form-row-inner");
  var btnBackToChoose = wrapperLogin.querySelectorAll(".btn-back-to-choose");
  var btnBackToPhoneNumber = wrapperLogin.querySelector(
    ".btn-back-to-phonenumber"
  );
  var signLogin = wrapperLogin.querySelector(".sign-login");

  cardsSignChoose.forEach((cardsign, i) => {
    cardsign.onclick = () => {
      formsGroup.classList.add("active");
      selectSignGroup.classList.remove("active");
      switchForms(formSign[i]);
    };
  });

  btnBackToChoose.forEach((btnBack) => {
    btnBack.onclick = () => {
      selectSignGroup.classList.add("active");
      formsGroup.classList.remove("active");
    };
  });

  btnBackToPhoneNumber.onclick = () => {
    signLogin.classList.add("active");
    selectSignGroup.classList.remove("active");
    formsGroup.classList.remove("active");
  };

  function switchForms(fsign) {
    for (i = 0; i < formSign.length; i++) {
      formSign[i].classList.remove("active");
    }
    fsign.classList.add("active");
  }
}

// Show Alert
var alertPlaceholder = document.getElementById("toastmessage-content");
var alertTrigger = document.getElementById("alertTrigger");

function toastMessage(title, message, type) {
  var wrapper = document.createElement("div");
  wrapper.innerHTML = `<div class="alert alert-dismissible fade show toast-content" aria-live="assertive" role="alert" data-bs-autohide="false" aria-atomic="true">
          <div class="toast-header bg-${type}">
              <i class="mdi mdi-information-outline"></i>
              <strong class="me-auto">${title}</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div class="toast-body">${message}</div>
      </div>`;

  alertPlaceholder.append(wrapper);
  toastMessageRemove();
}
function toastMessageRemove(tempDiv) {
  var tempDiv = alertPlaceholder.childElementCount;
  if (tempDiv > 1) {
    alertPlaceholder.removeChild(alertPlaceholder.firstChild);
  }
}

// if (alertTrigger) {
//   alertTrigger.addEventListener('click', function () {
//     toastMessage('خطا', 'Nice, you triggered this alert message!', 'danger')
//   })
// }

// Show Discount Element
function formDiscount() {
  if (document.getElementById("radio-discount-2").checked) {
    document.getElementById("discount-form").style.display = "block";
  } else document.getElementById("discount-form").style.display = "none";
}
function formInvite() {
  if (document.getElementById("radio-invite-2").checked) {
    document.getElementById("invite-form").style.display = "block";
  } else document.getElementById("invite-form").style.display = "none";
}

// Index Show Products
if (document.getElementById("btn-show-products") !== null) {
  var btnShoeProducts = document.getElementById("btn-show-products");
  var kasboomProducts = document.querySelector(".kasboom-products-list");
  btnShoeProducts.onclick = () => {
    kasboomProducts.classList.toggle("active");
  };
}

$(document).click(function (e) {
  var target = e.target;
  if (!$(target).closest(".products-content").length != 0) {
    $(".kasboom-products-list").removeClass("active");
  }
});

// Simple Carousel in index page
if (document.querySelector(".image-carousel") !== null) {
  var slideIndex = 0;
  showSlides();
  function showSlides() {
    var i;
    var slides = document.getElementsByClassName("image-carousel");
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {
      slideIndex = 1;
    }

    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 8000); // Change image every 2 seconds
  }
}

// Show Mobile Filter
var MQL = 100;
if ($(window).width() > MQL) {
  var headerHeight = $("#mobile-filter").height();
  $(window).on(
    "scroll",
    {
      previousTop: 0,
    },
    function () {
      var currentTop = $(window).scrollTop();
      //check if user is scrolling up
      if (currentTop < this.previousTop) {
        //if scrolling up...
        if (currentTop > -1 && $("#mobile-filter").hasClass("is-fixed")) {
          $("#mobile-filter").addClass("is-visible");
        } else {
          $("#mobile-filter").removeClass("is-visible is-fixed");
        }
      } else if (currentTop > this.previousTop) {
        //if scrolling down...
        $("#mobile-filter").removeClass("is-visible");
        if (
          currentTop > headerHeight &&
          !$("#mobile-filter").hasClass("is-fixed")
        )
          $("#mobile-filter").addClass("is-fixed");
      }
      this.previousTop = currentTop;
    }
  );
}

// Show Mobile Filter Content
// var body = document.getElementsByTagName("BODY")[0];

if (document.getElementById("btn-mob-sort") !== null) {
  var btnMobSort = document.getElementById("btn-mob-sort");
  var mobSortContent = document.getElementById("mob-sort-content");
  var btnCloseSort = document.querySelector(".btn-close-sort");
  btnMobSort.addEventListener("click", function () {
    mobSortContent.classList.add("active");
    body.classList.add("fixedposition");
  });
  btnCloseSort.addEventListener("click", function () {
    mobSortContent.classList.remove("active");
    body.classList.remove("fixedposition");
  });
}

if (document.getElementById("btn-mob-filter") !== null) {
  var btnMobFilter = document.getElementById("btn-mob-filter");
  var mobFilterContent = document.getElementById("mob-filter-content");
  var btnCloseFilter = document.querySelector(".btn-close-filter");
  btnMobFilter.addEventListener("click", function () {
    mobFilterContent.classList.add("active");
    body.classList.add("fixedposition");
  });
  btnCloseFilter.addEventListener("click", function () {
    mobFilterContent.classList.remove("active");
    body.classList.remove("fixedposition");
  });
}

// Show Lightbox
if (document.getElementById("lightbox-modal") !== null) {
  var modal = document.getElementById("lightbox-modal");
  var filePreviewImage = document.querySelectorAll(".file-preview-image");
  var lightboxImage = document.getElementById("lightbox-img");
  var captionText = document.getElementById("lightbox-caption");
  var closeLightBox = document.getElementsByClassName("lightbox-close")[0];
  filePreviewImage.forEach((item) => {
    item.onclick = function () {
      modal.style.display = "block";
      lightboxImage.src = this.src;
      captionText.innerHTML = this.alt;
    };
  });
  closeLightBox.onclick = function () {
    modal.style.display = "none";
  };
  modal.onclick = function () {
    modal.style.display = "none";
  };
}

var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Video Education Details
if (document.querySelector(".sub-collapse-header") !== null) {
  var subCollapseHeader = document.querySelectorAll(".sub-info");
  var courseVideoPreview = document.querySelector(".course-video-preview");
  subCollapseHeader.forEach((subItem, i) => {
    subItem.onclick = () => {
      ChangeVideoInfo(subItem);
      window.scroll(0, findPosition(courseVideoPreview) - 100);
    };
  });
}
function findPosition(obj) {
  var currenttop = 0;
  if (obj.offsetParent) {
    do {
      currenttop += obj.offsetTop;
    } while ((obj = obj.offsetParent));
    return [currenttop];
  }
}

function ChangeVideoInfo(videoItem) {
  let videoname = courseVideoPreview.querySelector(".vid-name");
  let videoSeason = courseVideoPreview.querySelector(".vid-season");
  let videoSource = courseVideoPreview.querySelector(".full-video");
  let sources = videoSource.getElementsByTagName("source");
  videoname.innerHTML = videoItem.querySelector(".name").innerHTML;
  videoSeason.innerHTML = videoItem.querySelector(".time").innerHTML;
  sources[0].src = videoItem.dataset.videoSrc;
  videoSource.load();
}

// Road Map Section
if (document.querySelector(".roadmap-section") !== null) {
  var roadmap = document.querySelector(".roadmap-section");
  var stepItem = roadmap.querySelectorAll(".step-item");
  var textSection = roadmap.querySelectorAll(".text-section");
  var btnPrevStep = roadmap.querySelector(".btn-prev-step");
  var btnNextStep = roadmap.querySelector(".btn-next-step");
  var stepCounter = 0;
  switchTab(stepCounter);
  stepItem.forEach((stitem, i) => {
    stitem.onclick = () => {
      step.classList.remove("active");
      stepsOverlay.classList.remove("active");
      itemClick(stitem, i);
    };
  });

  var step = document.querySelector(".side");
  var stepsOverlay = document.querySelector(".side-overlay");
  var btnShowSide = document.getElementById("btnshow-side");

  btnShowSide.onclick = () => {
    step.classList.add("active");
    stepsOverlay.classList.add("active");
  };
  stepsOverlay.onclick = () => {
    step.classList.remove("active");
    stepsOverlay.classList.remove("active");
  };
}

function itemClick(item, n) {
  for (i = 0; i < stepItem.length; i++) {
    stepItem[i].classList.remove("active");
  }
  textSection[stepCounter].classList.remove("active");
  stepCounter = n;
  switchTab(stepCounter);
}

function switchTab(n) {
  stepItem[n].classList.add("active");
  textSection[n].classList.add("active");
  if (n == 0) {
    btnPrevStep.style.display = "none";
  } else {
    btnPrevStep.style.display = "flex";
  }
  if (stepCounter >= stepItem.length - 1) {
    btnNextStep.style.display = "none";
  } else {
    btnNextStep.style.display = "flex";
  }
}

function nextStepsRoadMap(n) {
  stepItem[stepCounter].classList.remove("active");
  textSection[stepCounter].classList.remove("active");
  stepCounter = stepCounter + n;
  switchTab(stepCounter);
}

// For Preview Audio Ebook
if (document.querySelector(".preview-audiobook") !== null) {
  document.addEventListener("DOMContentLoaded", function () {
    GreenAudioPlayer.init({
      selector: ".preview-audiobook",
      stopOthersOnPlay: true,
      // showTooltips: true
    });
  });
}

if (document.querySelector(".show-message-form") !== null) {
  var btnShowMessageForm = document.querySelector(".show-message-form");
  var messageForm = document.querySelector(".messages-form");
  btnShowMessageForm.onclick = () => {
    messageForm.classList.toggle("active");
  };
}

// For User Profile
if (document.getElementById("btn-show-userMenu") !== null) {
  var btnShowUserMenu = document.getElementById("btn-show-userMenu");
  var UserMenuLinks_section = document.querySelector(".user-main-links");
  var overlay_profile = document.querySelector(".overlay-profile");

  btnShowUserMenu.onclick = () => {
    UserMenuLinks_section.classList.add("active");
    overlay_profile.classList.add("active");
  };
  overlay_profile.onclick = () => {
    UserMenuLinks_section.classList.remove("active");
    overlay_profile.classList.remove("active");
  };
}

// عملیات کپی کد معرف
function copyClipboard(el) {
  var selectParentElement = el.previousElementSibling.value;
  navigator.clipboard.writeText(selectParentElement);

  el.classList.add("copied");
  el.textContent = "کپی شد‌!";

  setTimeout(() => {
    el.classList.remove("copied");
    el.textContent = "کپی کن";
  }, 2000);
}
