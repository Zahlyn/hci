<?php include 'partials/html-head.php'; ?>
    
    <p>Now time for testing. Index</p>
    <form id="searchForm" action="search.php" method="get">
        <div class="form-group">
            <input type="text" id="searchBar" name="query" placeholder="Search course..." class="form-control">
            <input type="submit" id="searchSubmit" value="Search" class="btn btn-primary">
        </div>
    </form>
    <script>
        function init() {
            var courses = [];
            window.sessionStorage.setItem("courseArray", JSON.stringify(courses));
        }

        $(document).ready(init);
    </script>
<?php include 'partials/html-footer.php'; ?>