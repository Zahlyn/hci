<?php include 'partials/html-head.php'; ?>
    <?php
        $searchQuery = '';
        if (isset($_GET['query'])) {
            $searchQuery = $_GET['query'];
        }
        $category = '';
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
        }
        $program = '';
        if (isset($_GET['program'])) {
            $program = $_GET['program'];
        }
    ?>
    <div class="row">
        <div class="col-sm search-form-wrapper">
            <form id="searchForm" action="" method="get" class="form-inline">
                <div class="form-group">
                    <input type="hidden" name="program" value="<?php echo $program; ?>">
                    <input type="hidden" name="category" value="<?php echo $category; ?>">
                    <div class="search-hack">
                        <div id="searchTags" class="tags-in-search"></div>
                        <input type="text" id="searchBar" name="query" placeholder="Search course..." class="form-control">
                        <input type="submit" id="searchSubmit" value="Search" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
        <div id="tags" class="col-sm im-hiding-this-in-css">
                
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <form id="hiddenForm" action="" method="get">
                <div>
                    <input type="hidden" id="programHidden" name="program" value="<?php echo $program; ?>">
                    <input type="hidden" id="categoryHidden" name="category" value="<?php echo $category; ?>">
                    <input type="hidden" id="queryHidden" name="query" value="<?php echo $searchQuery; ?>">
                </div>
            </form>
        </div>
    </div>

<!-- CATEGORY COLLAPSABLE -->
    <div class="row">
        <div class="col-sm collapsable-categories-wrapper">
            <a class="collapsable-categories-link" data-toggle="collapse" href="#collapseCategories" role="button" aria-expanded="false" aria-controls="collapseCategories">
                <i class="fas fa-plus"></i> Add category
            </a>
            <div class="collapse" id="collapseCategories">
                <div class="card card-body collapsable-categories">
                    <div class="row">
                        <div class="col-sm">
                            <ul>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Behaviour and society</label></li>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Durability and Environment</label></li>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Law and government</label></li>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Religion and philosophy</label></li>
                            </ul> 
                        </div>
                        <div class="col-sm">
                            <ul>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Communication and education</label></li>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Economics and companies</label></li>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Music, art and design</label></li>
                            </ul>
                        </div>
                        <div class="col-sm">
                            <ul>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Culture, and history</label></li>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Health Languages</label></li>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Music, art and design</label></li>
                                <li class="category-item" onclick="addCategory('Music, art and design')"><label class="container-checkbox"><input type="checkbox" name="musicartdesign" value="Music"><span class="checkmark"></span>Natural and computer sciences</label></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm collapsable-categories-nav">
                            <a data-toggle="collapse" href="#collapseCategories" role="button" aria-expanded="false" aria-controls="collapseCategories">Close</a>
                        </div>
                    </div>
                    <!-- <button onclick="addCategory('Music, art and design')" type="button" class="btn btn-primary">Music, art and design</button> -->
                </div>
            </div>
            <button type="button" class="btn btn-tertiary btn-search-enroll" data-toggle="modal" data-target="#enrollModal">Enroll</button> 
        </div>
    </div>

<!-- TABLE -->
    <div class="row">
        <div class="col-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Course</th>
                        <th scope="col">Type</th>
                        <th scope="col">Code</th>
                        <th scope="col">Units</th>
                    </tr>
                </thead>
                <tbody id="tableBody">

                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        function loadJson(searchQuery, category, program) {
            $(function(){
                var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
                $.getJSON(url,function(data){
                    var html = $('#tableBody').html();
                    var courseArrayEnrolled = JSON.parse(window.sessionStorage.getItem("courseArray"));
                    $('#searchBar').val(searchQuery);
                    $.each(data, function(key,val){
                        if(val.length >= 10 && (searchQuery == val[1].toLowerCase() 
                            || val[0].toLowerCase().search(searchQuery) != -1 
                            || searchQuery == val[6].toString().toLowerCase() 
                            || searchQuery == '')) {
                            if(category == '' || category == val[8].toLowerCase()) {
                                if(program == '' || program == val[9].toLowerCase()) {
                                    if( val[5].toLowerCase() == 'exam'){
                                        html += '<tr class="table-item-exam">';
                                    } else {
                                        html += '<tr class="table-item-course">';
                                    }
                                    if(courseArrayEnrolled.indexOf(val[6]) != -1){
                                        html += '<td><input disabled type="checkbox" id="enrollCheckbox' + key + '"</td>' 
                                    } else {
                                        html += '<td><input type="checkbox" id="enrollCheckbox' + key + '"</td>'
                                    }
                                    html += '<td><a class="table-title" href="coursePage.php?courseCode=' + val[6] + '">' + val[0] + '</a><span class="table-period"> ' + val[11] + '</span><a class="table-title-see-more" href="coursePage.php?courseCode=' + val[6] + '">Read more</a></td>';
                                    html += '<td>' + val[5] + '</td>';
                                    html += '<td>' + val[6] + '</td>';
                                    html += '<td>' + val[7] + '</td>';
                                    html += '</tr>';
                                }
                            }
                        }
                    })
                    $('#tableBody').html(html);
                })
            })
        }

        function loadQuery() {
            var searchQuery = "<?php echo $searchQuery; ?>".toString().toLowerCase();
            var category = "<?php echo $category; ?>".toString().toLowerCase();
            var program = "<?php echo $program; ?>".toString().toLowerCase();
            loadJson(searchQuery, category, program);
            showProgramCategoryTags(program, category);
        }

        function removeTag(type) {
            $('#'+type+'Hidden').attr("value", '');
            $('#hiddenForm').submit();
            $("#searchTags").removeClass("category");
            $("#searchTags").removeClass("program");
        }
        
        function showProgramCategoryTags(program, category) {
            var html = $('#searchTags').html();
            if(program != ''){
                html += "<p onclick=\"removeTag('program')\">" + program + "<i class=\"fas fa-times-circle\"></i></p>";
                $("#searchTags").addClass("program");
            }
            if(category != ''){
                html += "<p onclick=\"removeTag('category')\">" + category + "<i class=\"fas fa-times-circle\"></i></p>";
                $("#searchTags").addClass("category");
            }
            $('#searchTags').html(html);
        }

        function init() {
            
            loadQuery();
            
        }

        $(document).ready(init);

        function enroll() {
            // course codes for subscribed courses are saved in the session storage
            // to refresh/ clear the enrolled courses, or close the tab

            var tableRows = document.getElementById('tableBody').children;
            var checkedCourses = 0;
            for(var i = 0; i < tableRows.length; i++) {
                var row = tableRows[i];
                if(row.children[0].children[0].checked) {
                    var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
                    var duplicate = false;
                    for(j in courseArray) {
                        if(courseArray[j] == row.children[3].innerHTML) {
                            duplicate = true;
                        }
                    }
                    if(!duplicate) {
                        courseArray.push(row.children[3].innerHTML);
                        checkedCourses++;
                    }
                    window.sessionStorage.setItem("courseArray", JSON.stringify(courseArray));
                }
                tableRows[i].children[0].children[0].checked = false;
            }
            $('#successMessage').html("Enrolled successfully in " + checkedCourses + " course(s)!")
            $('#successModal').modal('show');
        }

        function addCategory(cat) {
            $('#categoryHidden').attr("value", cat);
            $('#hiddenForm').submit();
        }
    </script>
<?php include 'partials/html-footer.php'; ?>