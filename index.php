<?php include 'partials/html-head.php'; ?>
    <div class="row">
        <div class="col-sm">
            <p>Now time for testing. Index</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <form id="searchForm" action="search.php" method="get" class="form-inline">
                <div class="form-group">
                    <input type="text" id="searchBar" name="query" placeholder="Search course..." class="form-control">
                    <input type="submit" id="searchSubmit" value="Search" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <script>
        function init() {
            if(window.sessionStorage.getItem("courseArray") === null) {
                var courses = [];
                window.sessionStorage.setItem("courseArray", JSON.stringify(courses));
            }
        }

        $(document).ready(init);
    </script>
<?php include 'partials/html-footer.php'; ?>