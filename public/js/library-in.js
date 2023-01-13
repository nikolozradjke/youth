function renderCards(data) {
	const poetryTab = document.querySelector(".poetry-tab.cards-wrapper ");
	poetryTab.innerHTML = "";

	if (data.status === 1) {
		let items = JSON.parse(data.items);
		const itemsHTML = items
			.map((element) => {
				return `
      <div class="library-card-download">
        <div class="lib-card-img">
          <img src="/img/icons/pdf.svg" alt="file" class="pdf">
          <a href="${
						element.file ? element.file : ""
					}" download class="align-items-center justify-content-center">
            <img src="/img/icons/pdf-download.svg" alt="download">
          </a>
        </div>
        <h5>${element.name}</h5>
        <span>${element.created_at}</span>
      </div>
	`;
			})
			.join("");

		poetryTab.innerHTML = itemsHTML;
		if (window.innerWidth < 991) {
			replaceHtml();
		}
	}
}

function ajaxCall(index) {
	if (index >= 0) {
		$.ajax({
			type: "GET",
			url: getLiteraturesRoute,
			data: { category: index },
			success: function success(data) {
				renderCards(data);
			},
			error: function error() {
				console.log("error");
			},
		});
	}
}

$(".poetry-li > .d-flex").on("click", function () {
	// console.log($(this).closest(".poetry-li").data("poetry-tab-index"));
	let index = $(this).closest(".poetry-li").data("poetry-tab-index");

	$(".poetry-li").removeClass("active");
	$(".poetry-li-in li").removeClass("active");

	$(this).closest(".poetry-li").addClass("active");
	ajaxCall(index);
});

$(".poetry-li-in > li > span").on("click", function () {
	$(".poetry-li-in li").removeClass("active");
	$(this).closest(".poetry-li-in li").addClass("active");
	let index = $(this).closest(".poetry-li-in li").data("poetry-tab-index");

	ajaxCall(index);
});

function replaceHtml() {
	let startResults = document.querySelector(
		".library-poetry-cards .cards-wrapper.active"
	).innerHTML;

	// console.log(
	// 	$(".poetry-li-in li.active > .results"),
	// 	"in",
	// 	$(".poetry-li.active > .results")
	// );

	if ($(".poetry-li.active > .results").length > 0) {
		$(".poetry-li.active > .results").html(startResults);
	}
	if ($(".poetry-li-in li.active > .results").length > 0) {
		$(".poetry-li-in li.active > .results").html(startResults);
	}
}

if (window.innerWidth < 991) {
	replaceHtml();
}

// var pageURL = window.location.href;

function removeMainTabClasses() {
	$(".organization-tab").removeClass("active");
	$(".library-in-switch .switch__item").removeClass("active");
}

var startPageUrl = window.location.href;
if (startPageUrl.includes("research-catalog")) {
	removeMainTabClasses();
	$('.library-in-switch .switch__item[data-tab-index="1"').addClass("active");
	$('.organization-tab[data-tab-index="1"]').addClass("active");
} else if (startPageUrl.includes("study-cabinet")) {
	removeMainTabClasses();
	$('.library-in-switch .switch__item[data-tab-index="2"').addClass("active");
	$('.organization-tab[data-tab-index="2"]').addClass("active");
} else {
	removeMainTabClasses();
	$('.library-in-switch .switch__item[data-tab-index="0"').addClass("active");
	$('.organization-tab[data-tab-index="0"]').addClass("active");
}

$libraryInTabNames = [
	"literature-catalog",
	"research-catalog",
	"study-cabinet",
];
$(".library-in-switch .switch__item").on("click", function () {
	removeMainTabClasses();

	$(this).addClass("active");
	var index = $(this).data("tab-index");
	$('.organization-tab[data-tab-index="' + index + '"]').addClass("active");
	var pageUrl = "#tab=" + $libraryInTabNames[index];
	window.history.pushState("", "", pageUrl);
});

// console.log(pageURL);
