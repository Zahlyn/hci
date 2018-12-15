<?php include 'partials/html-head.php'; ?>
    
    <form action="myCourses.php">
        <input type="submit" value="My Courses">
    </form>
    <p>Now time for testing. Search overview</p>
    <form id="searchForm" action="" method="get">
        <input type="text" id="searchBar" name="query" placeholder="Search course...">
        <input type="submit" id="searchSubmit" value="Search">
    </form>
    <br><br><br>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Course</th>
                <th>Code</th>
                <th>Units</th>
            </tr>
        </thead>
        <tbody id="tableBody">

        </tbody>
    </table>
    <button type="button" id="enrollSubmit" onclick="enroll()">Enroll</button>
    <?php
        $searchQuery = '';
        if (!empty($_GET)) {
            $searchQuery = $_GET['query'];
        }
    ?>
    <script>
        function loadJson(searchQuery, category, program) {
            $(function(){
                var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
                $.getJSON(url,function(data){
                    var html = $('#tableBody').html();
                    
                    $('#searchBar').val(searchQuery);
                    $.each(data, function(key,val){
                        if(val.length >= 8 && (searchQuery == val[1].toLowerCase() 
                            || val[0].toLowerCase().search(searchQuery) != -1 
                            || searchQuery == val[6].toLowerCase() 
                            || searchQuery == '')) {

                            html += '<tr>';
                            html += '<td><input type="checkbox" id="enrollCheckbox' + key + '"</td>'
                            html += '<td><a href="coursePage.php?courseCode=' + val[6] + '">' + val[0] + '</a></td>';
                            html += '<td>' + val[6] + '</td>';
                            html += '<td>' + val[7] + '</td>';
                            html += '</tr>';
                        }
                    })
                    $('#tableBody').html(html);
                })
            })
        }

        function loadQuery() {
            var searchQuery = "<?php echo $searchQuery; ?>".toLowerCase();
            loadJson(searchQuery, '', '');
        }
        
        function init() {
            
            loadQuery();
        }

        $(document).ready(init);

        function enroll() {
            // course codes for subscribed courses are saved in the session storage
            // to refresh/ clear the enrolled courses, visit index.php or close the tab

            var tableRows = document.getElementById('tableBody').children;
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
                    }
                    window.sessionStorage.setItem("courseArray", JSON.stringify(courseArray));
                }
                tableRows[i].children[0].children[0].checked = false;
            }
        }
    </script>
<?php include 'partials/html-footer.php'; ?>