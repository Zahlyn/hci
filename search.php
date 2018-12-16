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
        <div class="col-sm">
            <p>Now time for testing. Search overview</p>
        </div>
        <div class="col-sm">
            Testing some more
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <form id="searchForm" action="" method="get" class="form-inline">
                <div class="form-group">
                    <input type="hidden" name="program" value="<?php echo $program; ?>">
                    <input type="hidden" name="category" value="<?php echo $category; ?>">
                    <input type="text" id="searchBar" name="query" placeholder="Search course..." class="form-control">
                    <input type="submit" id="searchSubmit" value="Search" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <form id="hiddenForm" action="" method="get">
                <div>
                    <input type="hidden" name="program" value="<?php echo $program; ?>">
                    <input type="hidden" id="categoryHidden" name="category" value="<?php echo $category; ?>">
                    <input type="hidden" name="query" value="<?php echo $searchQuery; ?>">
                </div>
            </form>
            <p>Example category button</p>
            <button onclick="addCategory('Music, art and design')" type="button" class="btn btn-primary">Music, art and design</button> 
            <br> <br>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Course</th>
                        <th scope="col">Code</th>
                        <th scope="col">Units</th>
                    </tr>
                </thead>
                <tbody id="tableBody">

                </tbody>
            </table>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#enrollModal">Enroll</button>
        </div>
    </div>
    
    <script>
        function loadJson(searchQuery, category, program) {
            $(function(){
                var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
                $.getJSON(url,function(data){
                    var html = $('#tableBody').html();
                    $('#searchBar').val(searchQuery);
                    $.each(data, function(key,val){
                        if(val.length >= 10 && (searchQuery == val[1].toLowerCase() 
                            || val[0].toLowerCase().search(searchQuery) != -1 
                            || searchQuery == val[6].toLowerCase() 
                            || searchQuery == '')) {
                            if(category == '' || category == val[8].toLowerCase()) {
                                if(program == '' || program == val[9].toLowerCase()) {
                                    html += '<tr>';
                                    html += '<td><input type="checkbox" id="enrollCheckbox' + key + '"</td>'
                                    html += '<td><a href="coursePage.php?courseCode=' + val[6] + '">' + val[0] + '</a></td>';
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
            var searchQuery = "<?php echo $searchQuery; ?>".toLowerCase();
            var category = "<?php echo $category; ?>".toLowerCase();
            var program = "<?php echo $program; ?>".toLowerCase();
            loadJson(searchQuery, category, program);
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
                        if(courseArray[j] == row.children[2].innerHTML) {
                            duplicate = true;
                        }
                    }
                    if(!duplicate) {
                        courseArray.push(row.children[2].innerHTML);
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

    

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
    </button>

    <div class="modal" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enrollment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you wish to enroll in the course(s)?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Yes, enroll in all</button>
                </div>
            </div>
        </div>
    </div>
<?php include 'partials/html-footer.php'; ?>