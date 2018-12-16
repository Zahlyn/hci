<?php include 'partials/html-head.php'; ?>
<div class="front-page">
    <div class="row">
        <div class="col-sm">
            <p>Search for courses to explore.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <form id="searchForm" action="search.php" method="get" class="">
                <div class="form-group">
                    <input type="text" id="searchBar" name="query" placeholder="Search course..." class="form-control search-field">
                    <input type="submit" id="searchSubmit" value="Search" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <ul class="category-list">
                <li>
                    <a href="search.php?category=Music,%20art%20and%20design">Music, art and design</a>
                </li>
                <li>
                    <a href="search.php?category=Natural%20and%20Computer%20sciences">Natural and Computer sciences</a>
                </li>
            </ul> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm academic-requirements academic-requirements-home">
            <h5>See a list of courses based on program relevance or academic requirements</h5>
            <a href="search.php?program=Media"><button type="button" class="btn btn-tertiary">Program requirements</button></a>
        </div>
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