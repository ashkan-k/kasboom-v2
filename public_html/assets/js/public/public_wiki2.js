var wiki_results="";
var wiki_results_id=[];
var wiki_id=0;
var wiki_title="";
var wiki_price=0;
var idea_id=0;

_search = function (page) {
  var form = new FormData();
  var webOrMobile = $('#webOrMobile').val()
  var minPrice=$('#priceNumberMobileMin').text();
  var maxPrice=$('#priceNumberMobileMax').text();

  minPrice=parseInt(String(minPrice).replace(/,/g, ''));
  maxPrice=parseInt(String(maxPrice).replace(/,/g, ''));



  if (webOrMobile === 'web') {
    form.append("title", $('input[name="catRadio"]:checked').val());
    form.append("sort", $('#selectIdea').val());
    form.append("search", $('#searchInputWiki').val());
    form.append("priceNumberMin", minPrice);
    form.append("priceNumberMax", maxPrice);
    form.append("risk", $('input[name="riskRadio"]:checked').val());
  } else {
    form.append("title", $('input[name="catRadioMobile"]:checked').val());
    form.append("sort", $('input[name="selectIdeaMobile"]:checked').val());
    form.append("search", $('#searchInputWikiMobile').val());
    form.append("priceNumberMin", minPrice);
    form.append("priceNumberMax", maxPrice);
  }

  form.append("page", page);
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: "wikiidea/cat/search/ajax",
    type: "POST",
    data: form,
    processData: false,
    contentType: false,
    async: true,
    success: function (data) {
      $('#searchResult').html(data);
    }
  });
};

//searchBtnWiki , submitFilter ajax
$('.searchBtnWiki , #submitFilter').click(function () {
  _search(1);
});

//change select value
$("#selectIdea").change(function() {
  _search(1);
});

//first search
$(document).ready(function () {
  _search(1);
});

//pagination BtnPage
$(document).on("click", '#paginationBtnPage', function () {
  var id = $(this).data('id');
  _search(id);
});

if (jQuery(window).width() <= 992) {
  $('#webOrMobile').val('mobile')
} else {
  $('#webOrMobile').val('web')
}
$(window).resize(function() {
  if (jQuery(window).width() <= 992) {
    $('#webOrMobile').val('mobile')
  } else {
    $('#webOrMobile').val('web')
  }
});



///////////////////////////  detail idea ///////////////////

_search_detail = function (page) {
  var form = new FormData();
  form.append("page", page);
  form.append("ideaId", idea_id);
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: "wikiidea/comments/details/search",
    type: "POST",
    data: form,
    processData: false,
    contentType: false,
    async: true,
    success: function (data) {
      $('#resultSearch').html(data);
    }
  });
};


//storeComment
$('#storeComment').click(function () {
  var form = new FormData();
  form.append("commentTextarea", $('#commentTextarea').val());
  form.append("commentScore", $('#commentRange').text());
  form.append("ideaId", idea_id);
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: "wikiidea/store/comment",
    type: "POST",
    data: form,
    processData: false,
    contentType: false,
    async: true,
    success: function (result) {
      ShowMessage(result.message, result.type);
      if (!result.error) {
        $('#modal-sendcomments').modal('hide');
        $('#commentTextarea').val('')
      }
    }
  });
});

//storeLike
$('#storeLike').click(function () {
  var form = new FormData();
  form.append("ideaId", idea_id);
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: "wikiidea/store/like",
    type: "POST",
    data: form,
    processData: false,
    contentType: false,
    async: true,
    success: function (result) {
      ShowMessage(result.message, result.type);
      if (!result.error) {
        var text = $('#wikiLikeCountClass').text()
        var text = parseInt(text)
        if(result.data) {
          text = text + 1;
          $("#storeLike").removeClass();
          $("#storeLike").addClass("btn-like active");

        }
        else {
          text = text - 1;
          $("#storeLike").removeClass();
          $("#storeLike").addClass("btn-like");

        }
        $('#wikiLikeCountClass').text(text)


      }
    }
  });
});








