$(document).ready(() => {
    let storage = {
        search: "",
        status: [],
        featured: [],
        category_id: "",
        page: 0,
        take: 25,
        amountOfData: 0,
        totalPage: 1,
        url: $("#url").data("url"),
    };
    //handle search
    $("#search").keypress(
        debounce((e) => {
            if (e.keyCode === 13) {
                return 0;
            }
            storage.search = e.target.value;
            storage.page = 1;
            $("#pagination").simplePaginator("changePage", 1);
        }, 500)
    );

    $("#search").keyup(
        debounce((e) => {
            if (e.keyCode === 8) {
                storage.search = e.target.value;
                $("#pagination").simplePaginator("changePage", 1);
            }
            return 0;
        }, 500)
    );
    // end handle search

    // handle filter
    $(".filter").change((e) => {
        const selecter = e.target;
        const isChecked = selecter.checked;
        const name = selecter.name;
        const value = selecter.value;
        storage.page = 1;
        if (name === "status") {
            storage.status = isChecked
                ? [...storage.status, value]
                : [...storage.status.filter((e) => e !== value)];
        }

        if (name === "featured") {
            storage.featured = isChecked
                ? [...storage.featured, value]
                : [...storage.featured.filter((e) => e !== value)];
        }

        $(selecter).attr("disabled", true);
        setTimeout(() => {
            $(selecter).removeAttr("disabled");
        }, 500);
        $("#pagination").simplePaginator("changePage", 1);
    });
    // end handle filter

    //handle filter category
    $("#category").change((e) => {
        storage.category_id = e.target.value;
        storage.page = 1;
        $("#pagination").simplePaginator("changePage", 1);
    });
    //end handle filter category

    //choose show entries
    $("#showEntries").change((e) => {
        storage.take = e.target.value;
        storage.page = 1;
        $("#pagination").simplePaginator("changePage", 1);
    });
    //end choose show entries

    // load pagination
    $("#pagination").simplePaginator({
        totalPages: 1,
        maxButtonsVisible: 10,
        currentPage: 1,
        nextLabel: "next",
        prevLabel: "prev",
        firstLabel: "first",
        lastLabel: "last",
        clickCurrentPage: true,
        pageChange: function (page) {
            storage.page = parseInt(page);
            this.currentPage = storage.page;
            console.log(page);
            loadSearchFilter(storage);
        },
    });
    // end pagination

    // move fast page
    $("#movePage").keypress(
        debounce((e) => {
            let page = parseInt(e.target.value);
            // if user input value > total page
            if (page > storage.totalPage) {
                storage.page = storage.totalPage;
            } else {
                storage.page = page;
            }
            $("#pagination").simplePaginator("changePage", storage.page);
        }, 500)
    );
    // end fast page
});

// function debounce
const debounce = (callback, timeout = 500) => {
    let timer;
    return (...agrs) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            callback.apply(this, agrs);
        }, timeout);
    };
};
// end function debounce

// set total page
const setTotalPages = (storage) => {
    storage.totalPage = Math.round(storage.amountOfData / storage.take);
    $("#pagination").simplePaginator("setTotalPages", storage.totalPage);
    $(".totalpage").text(
        `Showing ${storage.page} to ${storage.totalPage} of ${storage.amountOfData} entries`
    );
};
// end handle pagination

//  call api Search
const loadSearchFilter = (storage) => {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#renderData").html("");

    $.ajax({
        type: "POST",
        url: storage.url,
        data: storage,
        dataType: "json",
        success: (res) => {
            let xhtml = "";
            let data = res.data || [];
            data.forEach((element) => {
                let status =
                    element.status === 1
                        ? ["Show", "success"]
                        : ["Hidden", "secondary"];
                let featured =
                    element.featured === 1
                        ? ["Featured", "primary"]
                        : ["Unfeatured", "danger"];

                xhtml += `
            <tr>
            <td>${element.id}</td>
            <td>${element.name}</td>
            <td>${element.price}</td>
            <td>${element.category.name}</td>
            <td><span class="right badge badge-${status[1]}">${status[0]}</span>
            </td>
            <td><span class="right badge badge-${featured[1]}">${featured[0]}</span>
            </td>
            </tr>
            `;
            });
            $("#renderData").append(xhtml);
            storage.amountOfData = res.amountOfData;
            setTotalPages(storage);
        },
        error: function (error) {
            console.log(error.message);
        },
    });
};
