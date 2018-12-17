<?php include 'partials/html-head.php'; ?>
<div class="front-page">
    <div class="row">
        <div class="col-sm">
            <h2>Search for courses to explore</h2>
        </div>
    </div>
    <div class="row">
        <div class="academic-requirements-top">
            <a href="search.php?program=Media"><i class="fas fa-graduation-cap"></i> See by academic requirement</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <form id="searchForm" action="search.php" method="get" class="">
                <div class="form-group">
                    <input type="text" id="searchBar" name="query" placeholder="Search course... (leave empty to see all)" class="form-control search-field">
                    <input type="submit" id="searchSubmit" value="Search" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="row category-list">
        <div class="col-sm">
            <p>Or explore a category that interests you</p>
            <ul class="category-list">
                <li>
                    <a href="search.php?category=Music,%20art%20and%20design">Music, art and design</a>
                </li>
                <li>
                    <a href="search.php?category=Natural%20and%20Computer%20sciences">Natural and Computer sciences</a>
                </li>
                <li>
                    <a href="search.php?category=Astronomy">Astronomy</a>
                </li>
                <li>
                    <a href="search.php?category=Economics">Economics</a>
                </li>
            </ul> 
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-sm academic-requirements academic-requirements-home">
            <h5>See a list of courses based on program relevance or academic requirements</h5>
            <a href="search.php?program=Media"><button type="button" class="btn btn-tertiary">Program requirements</button></a>
        </div>
    </div> -->
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