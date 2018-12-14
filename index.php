<?php include 'partials/html-head.php'; ?>
    <h1>Hi!</h1>
    <p>Now time for testing. Index</p>
    <form id="searchForm" action="search.php" method="get">
        <input type="text" id="searchBar" name="query" placeholder="Search course...">
        <input type="submit" id="searchSubmit" value="Search">
    </form>
    <script>
        function init() {
            var courses = [];
            window.sessionStorage.setItem("courseArray", JSON.stringify(courses));
        }

        $(document).ready(init);
    </script>
<?php include 'partials/html-footer.php'; ?>