const loading = () => {
    const loadingEl = $("#loading");

    // Show page loading

    // Hide after 3 seconds
    setTimeout(function () {
        loadingEl.remove();
    }, 300);
};

loading();
