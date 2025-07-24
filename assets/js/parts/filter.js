(function ($) {

    $('#filter input, #filter select, #filter button, #filter textarea').prop('disabled', true);

    $(window).on('load', function() {
        $('#filter input, #filter select, #filter button, #filter textarea').prop('disabled', false);
    });

    function initializeRangeSlider(rangeInput, priceInput, range)
    {
        let priceGap = 1;
        let minVal, maxVal;

        priceInput.on("input", function (e) {
            let minPrice = parseInt(priceInput.eq(0).val());
            let maxPrice = parseInt(priceInput.eq(1).val());
            let minValue = parseInt(rangeInput.eq(0).attr("min"));
            let maxValue = parseInt(rangeInput.eq(0).attr("max"));

            if (maxPrice - minPrice >= priceGap && maxPrice <= maxValue) {
                if ($(e.target).hasClass("input-min")) {
                    rangeInput.eq(0).val(minPrice);
                    let minValPercent =
                        ((minPrice - minValue) / (maxValue - minValue)) * 100;
                    range.css("left", minValPercent + "%");
                } else {
                    rangeInput.eq(1).val(maxPrice);
                    let maxValPercent =
                        ((maxValue - maxPrice) / (maxValue - minValue)) * 100;
                    range.css("right", maxValPercent + "%");
                }

                minVal = minPrice;
                maxVal = maxPrice;
            }
        });

        rangeInput.on("input", function (e) {
            let minVal = parseInt(rangeInput.eq(0).val());
            let maxVal = parseInt(rangeInput.eq(1).val());
            let minValue = parseInt(rangeInput.eq(0).attr("min"));
            let maxValue = parseInt(rangeInput.eq(0).attr("max"));

            if (maxVal - minVal < priceGap) {
                if ($(e.target).hasClass("range-min")) {
                    rangeInput.eq(0).val(maxVal - priceGap);
                } else {
                    rangeInput.eq(1).val(minVal + priceGap);
                }
            } else {
                priceInput.eq(0).val(minVal);
                priceInput.eq(1).val(maxVal);
                let minValPercent = ((minVal - minValue) / (maxValue - minValue)) * 100;
                let maxValPercent = ((maxValue - maxVal) / (maxValue - minValue)) * 100;
                range.css("left", minValPercent + "%");
                range.css("right", maxValPercent + "%");
            }

            minVal = minVal;
            maxVal = maxVal;
        });
    }

    const hourRangeInput = $(".wrap#price-hour .range-input input");
    const hourPriceInput = $(".wrap#price-hour .price-input input");
    const hourRange = $(".wrap#price-hour .slider .progress");
    initializeRangeSlider(hourRangeInput, hourPriceInput, hourRange);

    const twoHourRangeInput = $(".wrap#price-two-hour .range-input input");
    const twoHourPriceInput = $(".wrap#price-two-hour .price-input input");
    const twoHourRange = $(".wrap#price-two-hour .slider .progress");
    initializeRangeSlider(twoHourRangeInput, twoHourPriceInput, twoHourRange);

    const nightRangeInput = $(".wrap#price-night .range-input input");
    const nightPriceInput = $(".wrap#price-night .price-input input");
    const nightRange = $(".wrap#price-night .slider .progress");
    initializeRangeSlider(nightRangeInput, nightPriceInput, nightRange);

    const heightRangeInput = $(".wrap#model-height .range-input input");
    const heightPriceInput = $(".wrap#model-height .price-input input");
    const heightRange = $(".wrap#model-height .slider .progress");
    initializeRangeSlider(heightRangeInput, heightPriceInput, heightRange);

    const weightRangeInput = $(".wrap#model-weight .range-input input");
    const weightPriceInput = $(".wrap#model-weight .price-input input");
    const weightRange = $(".wrap#model-weight .slider .progress");
    initializeRangeSlider(weightRangeInput, weightPriceInput, weightRange);

    const ageRangeInput = $(".wrap#model-age .range-input input");
    const agePriceInput = $(".wrap#model-age .price-input input");
    const ageRange = $(".wrap#model-age .slider .progress");
    initializeRangeSlider(ageRangeInput, agePriceInput, ageRange);

    $(document).on("click", function (e) {
        const $clickedElement = $(e.target);

        if (
            $clickedElement.hasClass("select") ||
            $clickedElement.closest(".select").length > 0
        ) {
            return;
        }

        if (!$(".select").hasClass("select-clicked")) {
            $(".search input").val("");
            handleSearch();
        }

        const $clickedDropdown = $clickedElement.closest(".dropdown");
        $(".dropdown")
            .not($clickedDropdown)
            .find(".select")
            .removeClass("select-clicked");
        $(".dropdown")
            .not($clickedDropdown)
            .find(".caret")
            .removeClass("caret-rotate");
        $(".dropdown").not($clickedDropdown).find(".list").removeClass("list-open");
    });

    $(".dropdown").each(function () {
        const $select = $(this).find(".select");
        const $caret = $(this).find(".caret");
        const $list = $(this).find(".list");

        $select.on("click", function (e) {
            e.stopPropagation();

            $(".dropdown .select").not(this).removeClass("select-clicked");
            $(".dropdown .caret").not($caret).removeClass("caret-rotate");
            $(".dropdown .list").not($list).removeClass("list-open");

            $(this).toggleClass("select-clicked");
            $caret.toggleClass("caret-rotate");
            $list.toggleClass("list-open");

            if ($(this).hasClass("select-clicked")) {
                $(this).next(".search").find("input").focus();
            }

            if (!$(this).hasClass("select-clicked")) {
                $(".search input").val("");
                handleSearch();
            }
        });
    });
    handleSearch();

    function handleSelectAll(containerID)
    {
        let container = $("#" + containerID);
        let allCheckbox = container.find(".select-all-checkbox");
        let childCheckboxes = container
            .find('input[type="checkbox"]')
            .not(".select-all-checkbox");

        allCheckbox.change(function () {
            let isChecked = $(this).prop("checked");
            childCheckboxes.prop("checked", isChecked);
        });

        childCheckboxes.change(function () {
            let allChecked =
                childCheckboxes.filter(":checked").length === childCheckboxes.length;
            allCheckbox.prop("checked", allChecked);
        });
    }

    handleSelectAll("services_checkbox_container");
    handleSelectAll("area_checkbox_container");
    handleSelectAll("metro_checkbox_container");
    handleSelectAll("hair_color_checkbox_container");
    handleSelectAll("bust_checkbox_container");

    function updateMoreBtn(response)
    {
        let moreBtn = $("#more_btn");
        if ($.trim(response).length === 0) {
            moreBtn.hide();
        } else {
            moreBtn.show();
        }
    }

    function sendRequest(page)
    {
        let filter = $("#filter");
        let moreBtn = $("#more_btn");
        let modelVerified = $("#model_verified_checkbox").prop("checked")
            ? "checked"
            : "";
        let modelHasVideo = $("#model_has_video").prop("checked") ? "checked" : "";
        let lang = getCookie("pll_language");
        let defaultCurrency = getCookie("defaultCurrency");

        $.ajax({
            url: filter.attr("action"),
            type: filter.attr("method"),
            data:
                filter.serialize() +
                "&paged=" +
                page +
                "&checkbox=" +
                modelVerified +
                "&model_has_video=" +
                modelHasVideo,
            beforeSend: function (response) {
                if (defaultCurrency === 'usd' || lang === 'en') {
                    moreBtn.text("Loading...");
                } else {
                    moreBtn.text("Загрузка...");
                }
            },
            success: function (response) {
                $("#response").append(response);
                moreBtn.text("Показать еще").data("page", page + 1);
                if (defaultCurrency === 'usd' || lang === 'en') {
                    moreBtn.text("Show more...").data("page", page + 1);
                } else {
                    moreBtn.text("Показать еще").data("page", page + 1);
                }

                updateMoreBtn(response);

                $('.lazyload').Lazy({
                    threshold: 100,
                    effect: 'fadeIn',
                    placeholder: '',
                });

                initializeSliders();
            },
            error: function () {
                alert("Ошибка загрузки данных");
                if (defaultCurrency === 'usd' || lang === 'en') {
                    moreBtn.text("Show more...");
                } else {
                    moreBtn.text("Показать еще");
                }
            },
        });
    }

    $(document).on("click", "#more_btn", function () {
        let page = $(this).data("page");
        sendRequest(page);
    });

    $('input[type="checkbox"]').change(function () {
        let checkbox = $(this);
        let parentElement = checkbox.closest(".checkbox");

        if (checkbox.is(":checked")) {
            parentElement.addClass("active");
        } else {
            parentElement.removeClass("active");
        }
    });

    let $checkboxHandler = `
    #services_checkbox_container input[type="checkbox"],
    #area_checkbox_container input[type="checkbox"],
    #metro_checkbox_container input[type="checkbox"],
    #model_verified_checkbox, #model_has_video,
    #bust_checkbox_container input[type="checkbox"],
    #hair_color_checkbox_container input[type="checkbox"],
    #price_range_container input[type="range"],
    #price_range_container input[type="number"],
    #params_checkbox_container input[type="range"],
    #params_checkbox_container input[type="number"]
    `;

    $(document).ready(function () {
        initializeSliders();

        $(document).on("change", $checkboxHandler, function () {
            let filter = $("#filter");
            let formData = filter.serializeArray();

            let servicesArray = [];
            let areaArray = [];
            let metroArray = [];
            let bustSize = [];
            let hairColor = [];
            let priceHour = [];
            let priceTwoHour = [];
            let priceNight = [];
            let modelHeight = [];
            let modelWeight = [];
            let modelAge = [];

            $('#services_checkbox_container input[type="checkbox"]:checked').each(
                function () {
                    servicesArray.push($(this).val());
                }
            );

            $('#area_checkbox_container input[type="checkbox"]:checked').each(
                function () {
                    areaArray.push($(this).val());
                }
            );

            $('#metro_checkbox_container input[type="checkbox"]:checked').each(
                function () {
                    metroArray.push($(this).val());
                }
            );

            $('#bust_checkbox_container input[type="checkbox"]:checked').each(
                function () {
                    bustSize.push($(this).val());
                }
            );

            $('#hair_color_checkbox_container input[type="checkbox"]:checked').each(
                function () {
                    hairColor.push($(this).val());
                }
            );

            $('#price-hour input[type="range"]').each(function () {
                priceHour.push($(this).val());
            });

            $('#price-two-hour input[type="range"]').each(function () {
                priceTwoHour.push($(this).val());
            });

            $('#price-two-hour input[type="range"]').each(function () {
                priceNight.push($(this).val());
            });

            $('#model-height input[type="range"]').each(function () {
                modelHeight.push($(this).val());
            });

            $('#model-weight input[type="range"]').each(function () {
                modelWeight.push($(this).val());
            });

            $('#model-age input[type="range"]').each(function () {
                modelAge.push($(this).val());
            });

            $.ajax({
                url: filter.attr("action"),
                data: formData,
                type: filter.attr("method"),
                dataType: "html",
                beforeSend: function (response) {
                    $("#loader").css("display", "block").show();
                    $(".loader-body").css("display", "flex").show();
                },
                success: function (response) {
                    $("#response").html(response);
                    updateMoreBtn(response);
                    $("#more_btn").data("page", 2);
                    initializeSliders();
                },
                complete: function () {
                    $("#loader").css("display", "none").hide();
                    $(".loader-body").css("display", "none").hide();
                },
            });
        });
    });

    updateMoreBtn($("#response").html());
})(jQuery);
